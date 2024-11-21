<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ImageToTextController extends Controller {
    protected string $url = "https://vision.googleapis.com/v1/images:annotate";
    private string $img_data;

    private function preparePayload(string $base64) : array {
        return [
            "requests" => [
                [ "image" => [
                    "content" => $base64
                ],
                    "features" => [
                        [
                            "type" => "DOCUMENT_TEXT_DETECTION"
                        ]
                    ]
                ]
            ]
        ];
    }

    private function makeRequest(array $payload) : null|array {
        $response = Http::withHeaders([
            "Authorization" => "Bearer " . config('app.cloud_vision_api.g_token'),
            "x-goog-user-project" => config('app.cloud_vision_api.g_app_id'),
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
        if ($response_json === null || !isset($response_json["responses"][0]["fullTextAnnotation"]["text"])) {
            return null;
        }
        $full_text = $response_json["responses"][0]["fullTextAnnotation"]["text"];
        return str_replace("\n", " ", $full_text);
    }
}
