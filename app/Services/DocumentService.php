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
            $isChapter = preg_match('/^(BAB\s+[\dIVXLCDM]+:?.*?)$/i', $p, $chMatch);
            $isScene = preg_match('/^(SCENE\s+\d+:?.*?)$/i', $p, $scMatch);

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
                $secHtml .= '<h3 class="text-2xl sm:text-3xl font-extrabold font-serif text-slate-900 dark:text-slate-100 border-b-2 border-amber-500/40 pb-3 mb-6 flex items-center gap-3"><i class="fa-solid fa-feather-pointed text-amber-600 text-lg"></i> ' . e($sec['title']) . '</h3>';
            } else {
                $secHtml .= '<div class="px-4 py-2 bg-slate-900 text-cyan-300 font-mono text-xs font-bold rounded-xl border border-cyan-500/30 uppercase tracking-widest inline-flex items-center gap-2 mb-6 shadow-sm"><i class="fa-solid fa-clapperboard text-cyan-400"></i> ' . e($sec['title']) . '</div>';
            }

            foreach ($sec['paragraphs'] as $pIdx => $pText) {
                // Character name alone (Dialogue Speaker)
                if (in_array(trim($pText), $characters)) {
                    $charClass = match(strtoupper(trim($pText))) {
                        'PADMASARI' => 'text-amber-500 border-amber-500/40 bg-amber-500/10',
                        'LURAH' => 'text-rose-400 border-rose-500/40 bg-rose-500/10',
                        default => 'text-cyan-400 border-cyan-500/40 bg-cyan-500/10'
                    };
                    $secHtml .= '<div class="mt-6 mb-1 font-bold font-mono text-xs tracking-wider uppercase inline-block px-3 py-1 rounded-md border ' . $charClass . ' character-tag" data-character="' . e(trim($pText)) . '">' . e(trim($pText)) . '</div>';
                    continue;
                }

                // Stage Directions (in parentheticals or Ext/Int)
                if (str_starts_with($pText, '(') && str_ends_with($pText, ')')) {
                    $secHtml .= '<p class="text-slate-400 italic text-xs sm:text-sm bg-slate-800/40 border-l-2 border-cyan-400/60 p-3 rounded-r-xl my-3 font-sans">' . e($pText) . '</p>';
                    continue;
                }

                // Moral Lesson or Highlight Quote
                if (preg_match('/^(Pesan Moral|Petuah|Catatan:)/i', $pText)) {
                    $secHtml .= '<div class="my-6 p-5 bg-amber-500/10 border-l-4 border-amber-500 rounded-r-2xl text-amber-200 text-sm font-serif italic"><i class="fa-solid fa-quote-left text-amber-400 mr-2"></i>' . e($pText) . '</div>';
                    continue;
                }

                // Regular Paragraph
                $dropCapClass = ($pIdx === 0 && $sec['type'] === 'chapter') ? 'first-letter:text-4xl first-letter:font-extrabold first-letter:font-serif first-letter:text-amber-500 first-letter:float-left first-letter:mr-2 first-letter:leading-none' : '';
                $secHtml .= '<p class="text-slate-700 dark:text-slate-300 leading-relaxed text-base sm:text-lg mb-4 font-sans ' . $dropCapClass . '">' . nl2br(e($pText)) . '</p>';
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
