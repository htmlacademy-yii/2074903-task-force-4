<?php
namespace app\controllers;

use app\models\Cities;
use yii\web\Controller;

class TestCitiesController extends Controller
{
    public function actionIndex()
    {
        $firstCity = Cities::findOne(1);
        if ($firstCity) {
            var_dump($firstCity->name);
        }

        $volgograd = Cities::findOne(['name' => 'Волгоград']);
        if ($volgograd) {
            var_dump($volgograd->lat.' '.$volgograd->lng);
        }

        $syzran = Cities::findOne(['name' => 'Сызрань']);
        if ($syzran) {
            var_dump($syzran->id);
        }

        $newCity = new Cities();
        $newCity->attributes = [
            'name' => 'Феникс',
            'lat' => 33.4484000,
            'lng' => -112.0740000];
        $newCity->save();

        $phoenix = Cities::findOne(['name' => 'Феникс']);
        if ($phoenix) {
            $idPhoenixCheck = $phoenix->id;
            var_dump($phoenix->lat.' '.$phoenix->lng);
            $phoenix->delete();
        }

        $phoenixCheck = Cities::findOne(['id' => $idPhoenixCheck]);
        if (!$phoenixCheck) {
            var_dump('this row was deleted');
        }
    }
}
