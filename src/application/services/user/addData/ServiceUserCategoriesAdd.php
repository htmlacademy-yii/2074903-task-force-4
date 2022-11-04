<?php

declare(strict_types=1);

namespace omarinina\application\services\user\addData;

use omarinina\domain\models\user\ExecutorCategories;
use omarinina\domain\models\user\Users;
use Yii;

class ServiceUserCategoriesAdd
{
    /**
     * @param Users $user
     * @param array|null $categories
     * @return void
     * @throws \Throwable
     */
    public static function saveExecutorCategories(Users $user, ?array $categories = null) : void
    {
        if ($categories) {
            $user->deleteAllExecutorCategories();
            Yii::$app->db->transaction(function () use ($categories, $user) {
                $userId = $user->id;
                foreach ($categories as $categoryId) {
                        $newExecutorCategory = new ExecutorCategories();
                        $newExecutorCategory->categoryId = (int)$categoryId;
                        $newExecutorCategory->executorId = $userId;
                        $newExecutorCategory->save(false);
                }
            });
        }
    }
}
