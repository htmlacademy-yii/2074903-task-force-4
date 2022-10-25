<?php

namespace omarinina\application\services\location\point_receive;

use GuzzleHttp\Exception\GuzzleException;
use omarinina\infrastructure\constants\KeysConstants;
use GuzzleHttp\Client;

class ServiceGeoObjectReceive
{
    /**
     * @param string|null $location
     * @return object|null
     * @throws GuzzleException
     */
    public static function receiveGeoObjectFromYandexGeocoder(?string $location) : ?object
    {
        if ($location) {
            $client = new Client();
            $responseGeocoder = $client->request(
                'GET',
                'https://geocode-maps.yandex.ru/1.x',
                [
                    'query' =>
                    [
                        'apikey' => (new KeysConstants())->getApiGeocoderKey(),
                        'format' => 'json',
                        'geocode' => $location,
                        'results' => 1,
                    ]
                ]
            );

            $payloadGeocoder = json_decode($responseGeocoder->getBody());

            if ($payloadGeocoder
                    ->response
                    ->GeoObjectCollection
                    ->metaDataProperty
                    ->GeocoderResponseMetaData
                    ->found > 0) {
                return $payloadGeocoder
                    ->response
                    ->GeoObjectCollection
                    ->featureMember[0]
                    ->GeoObject;
            }
            return null;
        }
        return null;
    }
}
