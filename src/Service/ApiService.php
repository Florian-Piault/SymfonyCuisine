<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService{
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData(){
        $response = $this->client->request(
            'GET',
            'https://www.fruityvice.com/api/fruit/all'
        );
        return $response->toArray();
    }
}