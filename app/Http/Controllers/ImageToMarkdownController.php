<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ImageToMarkdownController extends Controller {
    protected string $api_key;
    protected string $url;

    protected string $prompt =
        "Your goal is to analyze the attached image data, extract the text in it and return it formatted as markdown. Look at the structure and use the appropriate headings, any bullet points, lists formatting etc . Only use the following syntax: [ ## Heading ] [ ### Subheading ] [ ##### Secondary subheading ] [ * list ] [ 1. Numbered list item (and following integers accordingly as needed) ][ *italic* ] [ **bold** ] [ ~~strikethrough~~ ] [ > quote line (if input text contains quotation marks, strip those, as markdown in quote blocks already adds them resulting in redundant duplicated quotes)] [| - | symbols if you need to draw a markdown table ] [ <u> underlined text </u> ]. You are allowed to correct typos, spelling errors or illegible words on a per-word basis. Do not alter the meaning, do not swap words, inject new words or otherwise modify input - you are to preserve the sense of the original. Do not change the text in any way other than described above. Output raw markdown and do not include any explanation or commentary.";

    public function __construct() {
        $this->api_key = config('app.gemini_api.g_ai_api_key');
        $this->url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $this->api_key;
    }

    private string $img_data;

    // helper 1
    private function preparePayload(string $base64) : array {
        return [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $this->prompt,
                        ],
                        [
                            "inline_data" => [
                                "mime_type" => "image/jpeg",
                                "data" => $base64,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    // helper 2
    private function makeRequest(array $payload) : null|array {
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
        ])->post($this->url, $payload);
        if ($response->status() !== 200 || !$response->successful()) {
            return null;
        }
        return $response->json();
    }

    public function noteToText(string $base64) : null|string {
        $payload = $this->preparePayload($base64);
        $response_json = $this->makeRequest($payload);
        if ($response_json === null) {
            return null;
        }
        $res = $response_json["candidates"][0]["content"]["parts"][0]["text"];
        return $res;
    }
}
