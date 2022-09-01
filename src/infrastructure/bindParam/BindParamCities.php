<?php declare(strict_types=1);

namespace omarinina\infrastructure\bindParam;

use PDO;

class BindParamCities extends PDO
{
    private $typeName = PDO::PARAM_STR;
    private $typeLat;
    private $typeLong;


}
