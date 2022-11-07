<?php

namespace omarinina\application\services\location\interfaces;

interface GeoObjectReceiveInterface
{
    /**
     * @param string|null $location
     * @return object|null
     */
    public function receiveGeoObjectFromYandexGeocoder(?string $location) : ?object;
}
