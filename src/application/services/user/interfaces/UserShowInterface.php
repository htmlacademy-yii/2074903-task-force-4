<?php

namespace omarinina\application\services\user\interfaces;

use omarinina\domain\models\user\Users;

interface UserShowInterface
{
    /**
     * @param $id
     * @return Users
     */
    public function getUserExecutorById($id) : Users;
}
