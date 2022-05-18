<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class HttpService
{
    /**
     *  Send the request to an external Service
     * 
     *  @param string $baseUri 
     *  @param string $requestUrl
     *  @param string $method
     *  @param array $headers
     *  @param array $payload
     * 
     *  @return \Illuminate\Http\Response
     */
    public function performRequest(string $baseUri, string $requestUrl, string $method, array $headers = [], array $payload = []): \Illuminate\Http\Response
    {
        // if(empty($headers)) {
        //     $response = Http::$method("{$baseUri}/{$requestUrl}", $payload);
        // } else {
        //     $response = Http::withHeaders($headers)->$method("{$baseUri}/{$requestUrl}", $payload);
        // }

        $response = Http::withHeaders($headers)->$method("{$baseUri}/{$requestUrl}", $payload);
        return response($response->json(), $response->status());
    }
}
