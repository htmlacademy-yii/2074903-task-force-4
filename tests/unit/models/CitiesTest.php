<?php
namespace tests\models;

use app\models\Cities;
use app\tests\fixtures\CitiesFixture;
use app\tests\fixtures\UsersFixture;

class CitiesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'cities' => [
                'class' => CitiesFixture::class,
                'dataFile' => '@app/tests/fixtures/data/cities.php'
            ],
            'users' => [
                'class' => UsersFixture::class,
                'dataFile' => '@app/tests/fixtures/data/users.php'
            ]
        ]);
    }

    public function testAddingNewCityWithCorrectData()
    {
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

    public function testRelationsWithUsersTable()
    {
        $checkedCity1 = Cities::findOne(2);
        $countUsers1 = $checkedCity1->users;
        $this->assertCount(2, $countUsers1);

        $checkedCity2 = Cities::findOne(1);
        $countUsers2 = $checkedCity2->users;
        $this->assertCount(1,$countUsers2);
    }
}
