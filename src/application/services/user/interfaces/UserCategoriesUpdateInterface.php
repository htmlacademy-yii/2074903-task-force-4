<?php

namespace omarinina\application\services\user\interfaces;

use omarinina\domain\models\user\Users;

interface UserCategoriesUpdateInterface
{
    /**
     * @param Users $user
     * @param array|null $categories
     * @return void
     */
    public function updateExecutorCategories(Users $user, ?array $categories = null) : void;
}
