<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CgoService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getDistancesBeetweenDepannageAndShop($lieuDepannage, $shop): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.tomtom.com/routing/1/calculateRoute/'.$lieuDepannage->getLat().','.$lieuDepannage->getLng().':'.$shop->getVille()->getLat().','.$shop->getVille()->getLng().'/json?key=CY0cA0IJXHBdI3e8kqVijtyRoxuV6ULL'
        );

        
        $array_reponse = $response->toArray();

        $filtredResponse = [
            'shop'     => $shop,
            'distance' => $array_reponse['routes'][0]['summary']['lengthInMeters'],
            'duration' => $array_reponse['routes'][0]['summary']['travelTimeInSeconds']
        ];


        return $filtredResponse;
        // return $response;
    }
}