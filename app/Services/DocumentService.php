<?php

namespace App\Services;

use ZipArchive;
use DOMDocument;
use DOMXPath;

class DocumentService
{
    protected array $fileMap = [
        'novel' => 'PADMASARI BENTUK NOVEL.docx',
        'naskah' => 'PADMASARI BENTUK NASKAH CERITA.docx',
        'drama' => 'PADMASARI BENTUK NASKAH DRAMA.docx',
    ];

    public function getDocument(string $type): array
    {
        $type = strtolower($type);
        if (!isset($this->fileMap[$type])) {
            $type = 'novel';
        }

        $filename = $this->fileMap[$type];
        $filePath = resource_path('dokumen/' . $filename);

        if (!file_exists($filePath)) {
            return $this->getFallbackDocument($type);
        }

        $paragraphs = $this->extractParagraphsFromDocx($filePath);
        return $this->parseParagraphsToStructure($type, $paragraphs);
    }

    protected function extractParagraphsFromDocx(string $filePath): array
    {
        $paragraphs = [];
        $zip = new ZipArchive();

        if ($zip->open($filePath) === true) {
            $xmlData = $zip->getFromName('word/document.xml');
            $zip->close();

            if ($xmlData) {
                $dom = new DOMDocument();
                @$dom->loadXML($xmlData);
                $xpath = new DOMXPath($dom);
                $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

                $pNodes = $xpath->query('//w:p');
                foreach ($pNodes as $pNode) {
                    $textNodes = $xpath->query('.//w:t', $pNode);
                    $line = '';
                    foreach ($textNodes as $tNode) {
                        $line .= $tNode->nodeValue;
                    }
                    $trimmed = trim($line);
                    if ($trimmed !== '') {
                        $paragraphs[] = $trimmed;
                    }
                }
            }
        }

        return $paragraphs;
    }

    protected function parseParagraphsToStructure(string $type, array $paragraphs): array
    {
        $docTitle = match($type) {
            'novel' => 'Padmasari Edisi Novel',
            'naskah' => 'Padmasari Naskah Cerita',
            'drama' => 'Padmasari Pentas Drama',
        };

        $theme = '';
        $sections = [];
        $characters = [];
        $currentSection = null;
        $formattedHtml = '';

        foreach ($paragraphs as $index => $p) {
            // Check Tema
            if (preg_match('/^Tema:\s*(.*)$/i', $p, $m)) {
                $theme = trim($m[1]);
                continue;
            }

            // Check Judul / Header awal
            if (preg_match('/^(DOKUMEN\s+\d+:|Judul:|Genre:)/i', $p)) {
                continue;
            }

            // Detect BAB (for Novel) or SCENE (for Naskah/Drama)
            $isChapter = preg_match('/^(BAB\s+[\dIVXLCDM]+(?::\s*[^.\n\r]{1,50})?)(.*)$/i', $p, $chMatch);
            $isScene = preg_match('/^(SCENE\s+\d+(?::\s*[^.\n\r]{1,50})?)(.*)$/i', $p, $scMatch);

            if ($isChapter || $isScene) {
                if ($currentSection) {
                    $sections[] = $currentSection;
                }

                $titleText = $isChapter ? trim($chMatch[1]) : trim($scMatch[1]);
                $sectionId = 'section-' . (count($sections) + 1);

                $currentSection = [
                    'id' => $sectionId,
                    'title' => $titleText,
                    'type' => $isChapter ? 'chapter' : 'scene',
                    'paragraphs' => [],
                    'html' => ''
                ];

                // If remaining text exists in the same paragraph line, add it as first paragraph
                $remainingText = $isChapter ? trim($chMatch[2] ?? '') : trim($scMatch[2] ?? '');
                if ($remainingText !== '') {
                    $currentSection['paragraphs'][] = $remainingText;
                }
                continue;
            }

            // Extract Characters in Dialogue (CAPS ALL before dialogue or lines like "PADMASARI", "LURAH", etc.)
            if (preg_match('/^([A-Z\s]{3,25})$/', $p, $charMatch)) {
                $charName = trim($charMatch[1]);
                if (!in_array($charName, ['EXT', 'INT', 'SIANG', 'MALAM', 'PAGI', 'DOKUMEN', 'WAWACAN']) && !in_array($charName, $characters)) {
                    $characters[] = $charName;
                }
            }

            if (!$currentSection) {
                $currentSection = [
                    'id' => 'section-1',
                    'title' => $type === 'novel' ? 'Pendahuluan' : 'Scene 1',
                    'type' => $type === 'novel' ? 'chapter' : 'scene',
                    'paragraphs' => [],
                    'html' => ''
                ];
            }

            $currentSection['paragraphs'][] = $p;
        }

        if ($currentSection) {
            $sections[] = $currentSection;
        }

        // Format HTML for each section
        foreach ($sections as &$sec) {
            $secHtml = '<div id="' . e($sec['id']) . '" class="doc-section mb-12 scroll-mt-24">';
            
            if ($sec['type'] === 'chapter') {
                $secHtml .= '<h3 class="text-2xl sm:text-3xl font-extrabold font-serif border-b border-slate-200 dark:border-slate-800 pb-3 mb-6 flex items-center gap-3"><i class="fa-solid fa-feather-pointed text-blue-600 dark:text-blue-400 text-lg"></i> ' . e($sec['title']) . '</h3>';
            } else {
                $secHtml .= '<div class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-slate-100 font-mono text-xs font-bold rounded-xl border border-slate-300 dark:border-slate-700 uppercase tracking-widest inline-flex items-center gap-2 mb-6 shadow-xs"><i class="fa-solid fa-clapperboard text-emerald-700 dark:text-emerald-400"></i> ' . e($sec['title']) . '</div>';
            }

            foreach ($sec['paragraphs'] as $pIdx => $pText) {
                // Character name alone (Dialogue Speaker)
                if (in_array(trim($pText), $characters)) {
                    $charClass = match(strtoupper(trim($pText))) {
                        'PADMASARI' => 'text-blue-900 dark:text-blue-200 border-blue-300 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/60',
                        'LURAH' => 'text-rose-900 dark:text-rose-300 border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/50',
                        default => 'text-slate-900 dark:text-slate-200 border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/60'
                    };
                    $secHtml .= '<div class="mt-6 mb-2 font-bold font-mono text-xs tracking-wider uppercase inline-block px-3 py-1 rounded-md border ' . $charClass . ' character-tag" data-character="' . e(trim($pText)) . '">' . e(trim($pText)) . '</div>';
                    continue;
                }

                // Stage Directions (in parentheticals or Ext/Int)
                if (str_starts_with($pText, '(') && str_ends_with($pText, ')')) {
                    $secHtml .= '<p class="italic text-sm bg-slate-100 dark:bg-slate-800/60 border-l-4 border-slate-400 dark:border-slate-600 p-3.5 rounded-r-xl my-3 font-sans leading-relaxed opacity-90">' . e($pText) . '</p>';
                    continue;
                }

                // Moral Lesson or Highlight Quote
                if (preg_match('/^(Pesan Moral|Petuah|Catatan:)/i', $pText)) {
                    $secHtml .= '<div class="my-6 p-5 bg-slate-100 dark:bg-slate-800/80 border-l-4 border-blue-600 dark:border-blue-400 rounded-r-2xl text-slate-900 dark:text-slate-100 text-base font-serif italic"><i class="fa-solid fa-quote-left text-blue-600 dark:text-blue-400 mr-2"></i>' . e($pText) . '</div>';
                    continue;
                }

                // Regular Paragraph
                $dropCapClass = ($pIdx === 0 && $sec['type'] === 'chapter') ? 'first-letter:text-4xl first-letter:font-extrabold first-letter:font-serif first-letter:text-slate-900 dark:first-letter:text-slate-100 first-letter:float-left first-letter:mr-2.5 first-letter:leading-none' : '';
                $secHtml .= '<p class="leading-relaxed text-base sm:text-lg mb-5 font-sans ' . $dropCapClass . '">' . nl2br(e($pText)) . '</p>';
            }

            $secHtml .= '</div>';
            $sec['html'] = $secHtml;
            $formattedHtml .= $secHtml;
        }

        return [
            'type' => $type,
            'title' => $docTitle,
            'theme' => $theme,
            'paragraphs' => $paragraphs,
            'sections' => $sections,
            'characters' => array_values(array_unique($characters)),
            'formatted_html' => $formattedHtml
        ];
    }

    protected function getFallbackDocument(string $type): array
    {
        return [
            'type' => $type,
            'title' => ucfirst($type) . ' Padmasari',
            'theme' => 'Kedaulatan & Emansipasi Perempuan',
            'paragraphs' => [],
            'sections' => [],
            'characters' => [],
            'formatted_html' => '<div class="text-center py-12 text-slate-400">Dokumen statis sedang dimuat...</div>'
        ];
    }
}
