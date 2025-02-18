<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class MarkdownProcessor {
    public function stripMdToPlain(string $md) : string {
        $html = Str::of($md)->markdown();
        $raw = strip_tags($html);
        // manually remove leftovers
        $raw = preg_replace(
            [
                "/#{1,6}\s*/", // heading leftovers
                '/<[^>]*>/', // any potentially remaining html tags
                '/~~/', // strikethrough text leftovers
                '/-{2,}/', // multiple dashes
                '/^-{2,}/', //tables leftovers and dividers
                "/\|/", // table vertical leftovers
            ],
            '',
            $raw
        );
        $raw = preg_replace(["/\s+/", "/\n/"], ' ', $raw); // truncate spaces, remove newlines

        return trim($raw);
    }
}
