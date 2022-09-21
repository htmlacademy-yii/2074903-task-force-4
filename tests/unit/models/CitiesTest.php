<?php
namespace tests\models;

use app\models\Cities;
use app\tests\fixtures\CitiesFixture;

class CitiesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => CitiesFixture::class,
                'dataFile' => '@tests/fixtures/data/cities.php'
            ]
        ]);
    }



//    public function _fixtures()
//    {
//        return ['cities' => CitiesFixture::class];
//    }

    public function testAddingNewCityWithCorrectData()
    {
        //don't understand why there is no CitiesFixture and
        //how concrete data for fixture to add in CitiesFixture
        $this->assertCount(4, Cities::find()->all());
        $this->tester->seeRecord(Cities::class, ['name' => 'Феникс']);
        $this->tester->seeRecord(Cities::class, ['name' => 'Варшава']);
        $this->tester->seeRecord(Cities::class, ['name' => 'Винтертур']);
        $this->tester->seeRecord(Cities::class, ['name' => 'Ханой']);

        $newCity = new Cities();
        $newCity->name = 'Минск';
        $newCity->lat = 53.9000000;
        $newCity->lng = 27.5667000;

        $newCity->save();

        $this->assertNotNull($newCity->id);

        $this->assertCount(5, Cities::find()->all());
        $this->tester->seeRecord(Cities::class, ['name' => 'Минск']);
    }
}
