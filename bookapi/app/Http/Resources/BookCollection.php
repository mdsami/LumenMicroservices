<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookCollection extends JsonResource
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
            'author_id' => $this->author_id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'created_at' => isset($this->created_at) ? (string) $this->created_at : null,
            'updated_at' => isset($this->updated_at) ? (string) $this->updated_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => $apiGateway ? "{$apiGateway}/$this->id" : route('books.show', ['book' => $this->id]),
                ],
            ],
        ];
    }
}
