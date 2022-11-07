<?php

namespace omarinina\application\services\user\interfaces;

use omarinina\application\services\user\dto\NewUserDto;
use omarinina\domain\models\user\Users;

interface UserCreateInterface
{
    /**
     * @param NewUserDto $dto
     * @return Users|null
     */
    public function createNewUser(NewUserDto $dto) : ?Users;
}
