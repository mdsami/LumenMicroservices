<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /**
         *  ? If the environment variable: API_GATEWAY_BASE_URL is defined
         *  ?   AND
         *  ? The request is coming from the api_gateway 
         *  ?   THEN 
         *  ? Use the environment variable: API_GATEWAY_BASE_URL for "href" link  
         */ 
        $apiGateway = null;
        if(env('API_GATEWAY_BASE_URL') && preg_match('/GuzzleHttp*/', $request->server('HTTP_USER_AGENT'))) {
            $apiGateway = env('API_GATEWAY_BASE_URL');
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'country' => $this->country,
            'created_at' => isset($this->created_at) ? (string) $this->created_at : null,
            'updated_at' => isset($this->updated_at) ? (string) $this->updated_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => $apiGateway ? "{$apiGateway}/$this->id" : route('authors.show', ['author' => $this->id]),
                ],
            ],
        ];
    }
}
