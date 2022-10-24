<?php

namespace omarinina\application\services\location\point_receive;

use GuzzleHttp\Exception\GuzzleException;
use omarinina\infrastructure\constants\KeysConstants;
use GuzzleHttp\Client;

class ServiceLocationPointReceive
{
    /**
     * @param string|null $fullLocation
     * @return void|null|string
     * @throws GuzzleException
     */
    public static function receivePointFromYandexGeocoder(?string $fullLocation)
    {
        if ($fullLocation) {
            $client = new Client();
            $responseGeocoder = $client->request(
                'GET',
                'https://geocode-maps.yandex.ru/1.x',
                [
                    'query' =>
                    [
                        'apikey' => (new KeysConstants())->getApiGeocoderKey(),
                        'format' => 'json',
                        'geocode' => $fullLocation,
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
                    ->GeoObject
                    ->Point
                    ->pos;
            }
            return null;
        }
    }
}
