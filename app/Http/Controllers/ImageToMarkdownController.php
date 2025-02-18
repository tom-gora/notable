<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class ImageToMarkdownController extends Controller {
    protected string $api_key;

    protected string $url;

    protected string $prompt =
        "Your goal is to analyze the attached image data, extract the text in it and return it formatted as markdown. Your primary directive for the task is to only provide formatting to markdown and not alter the provided content by means of adding or subtracting words. Only corrections are allowed. THIS IS A RULE YOU ARE NOT ALLOWED TO BREAK. Look at the structure and use the appropriate headings, any bullet points, lists formatting etc . Only use the following syntax: [ ## Heading ] [ ### Subheading ] [ ##### Secondary subheading ] [ * list ] [ 1. Numbered list item (and following integers accordingly as needed) ][ *italic* ] [ **bold** ] [ ~~strikethrough~~ ] [ > quote line (if input text contains quotation marks, strip those, as markdown in quote blocks already adds them resulting in redundant duplicated quotes)] [| - | symbols if you need to draw a markdown table ] [ <u> underlined text </u> ]. You are allowed to correct minor typos, spelling errors or illegible words on a per-word basis. Let me remind you, DO NOT alter the meaning, do not swap words, inject new words or otherwise modify input - you are to preserve the sense of the original. Do not change the text in any way other than described above. Output raw markdown and do not include any explanation or commentary or any additional text that isn't in the image - the content MUST be one to one mach of the text in the picture.";

    public function __construct() {
        $this->api_key = config('app.gemini_api.g_ai_api_key');
        $this->url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite-preview-02-05:generateContent?key=' . $this->api_key;
    }

    private string $img_data;

    /**
     * @return array<string,array<int,array<string,array<int,mixed>>>>
     */
    private function preparePayload(string $base64) : array {
        return [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $this->prompt,
                        ],
                        [
                            'inline_data' => [
                                'mime_type' => 'image/jpeg',
                                'data' => $base64,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param  array<int,mixed>  $payload
     */
    private function makeRequest(array $payload) : ?array {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->url, $payload);
        if ($response->status() !== 200 || !$response->successful()) {
            return null;
        }
        return $response->json();
    }

    public function noteToText(string $base64) : ?string {
        $payload = $this->preparePayload($base64);
        $response_json = $this->makeRequest($payload);
        if ($response_json === null) {
            return null;
        }
        $res = $response_json['candidates'][0]['content']['parts'][0]['text'];
        return $res;
    }
}
