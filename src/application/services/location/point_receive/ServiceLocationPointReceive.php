<?php

namespace omarinina\application\services\location\point_receive;

use omarinina\infrastructure\constants\KeysConstants;

class ServiceLocationPointReceive
{
    /**
     * @param string|null $fullLocation
     * @return void|null|string
     */
    public static function receivePointFromYandexGeocoder(?string $fullLocation)
    {
        if ($fullLocation) {
            $params = [
                'apikey' => (new KeysConstants())->getApiGeocoderKey(),
                'format' => 'json',
                'geocode' => $fullLocation,
                'results' => 1,
            ];
            $response = json_decode(
                file_get_contents(
                    'https://geocode-maps.yandex.ru/1.x/?' . http_build_query(
                        $params,
                        '',
                        '&'
                    )
                )
            );
            if ($response->response->GeoObjectCollection->metaDataProperty->GeocoderResponseMetaData->found > 0) {
                return $response->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
            }
            return null;
        }
    }
}
