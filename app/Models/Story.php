<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $guarded = [];

    public function getFormattedContentAttribute(): string
    {
        $content = $this->content;

        // Remove markdown metadata headers if present
        $content = preg_replace('/^\s*##\s*.*?\n/m', '', $content);
        $content = preg_replace('/^\s*\*\*(Tema\/Genre|Naskah Acuan Master|Fokus Adegan|Pesan Moral)\*\*.*?\n/m', '', $content);
        $content = preg_replace('/^\s*---\s*\n/m', '', $content);

        // Convert markdown headers ### [Bab I: ...] or ### Bab I: ...
        $content = preg_replace_callback('/^\s*###\s*\[?(.*?)\]?\s*$/m', function ($matches) {
            $title = trim($matches[1]);
            return '<h3 class="text-base sm:text-lg font-bold font-serif text-gray-900 mt-8 mb-3 flex items-center gap-2 border-b border-amber-200/60 pb-2"><i class="fa-solid fa-feather-pointed text-amber-600 text-xs"></i> ' . e($title) . '</h3>';
        }, $content);

        // Convert standalone "Bab I: ..." lines into styled headings
        $content = preg_replace_callback('/^\s*(Bab\s+[IVXLCDM\d]+:.*?)$/m', function ($matches) {
            $title = trim($matches[1]);
            return '<h3 class="text-base sm:text-lg font-bold font-serif text-gray-900 mt-8 mb-3 flex items-center gap-2 border-b border-amber-200/60 pb-2"><i class="fa-solid fa-feather-pointed text-amber-600 text-xs"></i> ' . e($title) . '</h3>';
        }, $content);

        // Convert markdown bold **text** and italic *text*
        $content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content);
        $content = preg_replace('/(?<!\*)\*(?!\*)(.*?)(?<!\*)\*(?!\*)/', '<em>$1</em>', $content);

        // Split paragraphs by blank lines
        $paragraphs = preg_split('/\n\s*\n/', trim($content));
        $formattedHtml = '';

        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);
            if (empty($paragraph)) continue;

            if (str_starts_with($paragraph, '<h3')) {
                $formattedHtml .= $paragraph;
            } else {
                $formattedHtml .= '<p class="text-gray-700 leading-relaxed text-sm sm:text-base mb-5 font-sans">' . nl2br($paragraph) . '</p>';
            }
        }

        return $formattedHtml;
    }
}
