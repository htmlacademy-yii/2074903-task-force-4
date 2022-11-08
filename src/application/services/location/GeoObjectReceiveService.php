<?php

declare(strict_types=1);

namespace omarinina\application\services\location;

use GuzzleHttp\Exception\GuzzleException;
use omarinina\application\services\location\interfaces\GeoObjectReceiveInterface;
use omarinina\infrastructure\constants\KeysConstants;
use GuzzleHttp\Client;
use Yii;
use yii\base\InvalidConfigException;

class GeoObjectReceiveService implements GeoObjectReceiveInterface
{
    /**
     * @param string|null $location
     * @return object|null
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function receiveGeoObjectFromYandexGeocoder(?string $location) : ?object
    {
        if ($location) {
            /** @var Client $client */
            $client = Yii::$app->get('yandexGeoClient');
            $responseGeocoder = $client->request(
                'GET',
                '',
                [
                    'query' =>
                    [
                        'apikey' => KeysConstants::API_GEOCODER_KEY,
                        'format' => 'json',
                        'geocode' => $location,
                        'results' => 1,
                    ]
                ]
            );

            $jsonGeocoder = $responseGeocoder->getBody();
            $payloadGeocoder = json_decode((string)$jsonGeocoder);

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
