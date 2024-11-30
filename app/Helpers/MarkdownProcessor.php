<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MarkdownProcessor
{
    public function stripMdToPlain(string $md): string
    {
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

    public function saveToPdf(string $md, string $title): Response
    {
        $html = Str::of($md)->markdown();
        $pdf = Pdf::loadHTML($html);
        $title_to_snake_case = Str::of($title)->snake()->title();

        return $pdf->download($title_to_snake_case.'.pdf');
    }
}
