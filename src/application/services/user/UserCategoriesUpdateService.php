<?php

declare(strict_types=1);

namespace omarinina\application\services\user;

use omarinina\application\services\user\interfaces\UserCategoriesUpdateInterface;
use omarinina\domain\models\user\ExecutorCategories;
use omarinina\domain\models\user\Users;
use Yii;

class UserCategoriesUpdateService implements UserCategoriesUpdateInterface
{
    /**
     * @param Users $user
     * @param array|null $categories
     * @return void
     * @throws \Throwable
     */
    public function updateExecutorCategories(Users $user, ?array $categories = null) : void
    {
        if ($categories) {
            $currentExecutorCategories = array_map(
                function ($executorCategory) {
                    return $executorCategory->id;
                },
                $user->executorCategories
            );

            $outdatedCategories = array_diff($currentExecutorCategories, $categories);
            $updatedCategories = array_diff($categories, $currentExecutorCategories);
            $userId = $user->id;

            if ($outdatedCategories) {
                Yii::$app->db->transaction(function () use ($outdatedCategories, $userId) {
                    foreach ($outdatedCategories as $categoryId) {
                        /** @var ExecutorCategories $category */
                        $category = ExecutorCategories::find()
                            ->where(['categoryId' => $categoryId])
                            ->andWhere(['executorId' => $userId])
                            ->one();
                        $category->deleteExecutorCategory();
                    }
                });
            }

            if ($updatedCategories) {
                Yii::$app->db->transaction(function () use ($updatedCategories, $userId) {
                    foreach ($updatedCategories as $categoryId) {
                        $newExecutorCategory = new ExecutorCategories();
                        $newExecutorCategory->categoryId = (int)$categoryId;
                        $newExecutorCategory->executorId = $userId;
                        $newExecutorCategory->save(false);
                    }
                });
            }
        }
    }
}
