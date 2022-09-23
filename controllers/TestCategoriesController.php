<?php
namespace app\controllers;

use app\models\Categories;
use yii\web\Controller;

class TestCategoriesController extends Controller
{
    public function actionIndex()
    {
        $category1 = Categories::findOne(1);
        if ($category1) {
            var_dump($category1->name);
        }

        $category2 = Categories::findOne(['icon' => 'neo']);
        if ($category2) {
            var_dump($category2->name);
        }

        $newCategory = new Categories();
        $newCategory->attributes = [
            'name' => 'Создание сайта',
            'icon' => 'web develop'];
        $newCategory->save();

        $category3 = Categories::findOne(['name' => 'Создание сайта']);
        if ($category3) {
            var_dump($category3->icon);
            $category3->delete();
        }

        $categoryCheck = Categories::findOne(['icon' => 'web develop']);
        if (!$categoryCheck) {
            var_dump('this row was deleted');
        }
    }
}
