<?php declare(strict_types=1);

namespace omarinina\infrastructure\bindParam;

use PDO;

class BindParamCategories extends PDO
{
    private $typeName = PDO::PARAM_STR;
    private $typeIcon = PDO::PARAM_STR;


}
