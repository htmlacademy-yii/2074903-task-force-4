<?php

namespace omarinina\infrastructure\models\form;

use GuzzleHttp\Exception\GuzzleException;
use omarinina\application\services\location\point_receive\ServiceLocationPointReceive;
use omarinina\domain\models\Categories;
use omarinina\domain\models\Cities;
use yii\base\Model;

class CreateTaskForm extends Model
{
    /** @var string */
    public string $name = '';

    /** @var string */
    public string $description = '';

    /** @var int */
    public int $categoryId = 0;

    /** @var null|string */
    public ?string $location = null;

    /** @var string */
    public string $budget = '';

    /** @var string|null */
    public ?string $expiryDate = null;

    /** @var array */
    public array $files = [];

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'categoryId' => 'Категория',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'expiryDate' => 'Срок исполнения',
            'files' => 'Файлы'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'budget', 'categoryId', 'description'], 'required'],
            [['name'], 'string', 'min' => 10, 'max' => 255],
            [['description'], 'string', 'min' => 30, 'max' => 2000],
            [['categoryId'], 'exist', 'targetClass' => Categories::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['expiryDate'], 'default', 'value' => null],
            [['budget'], 'integer', 'min' => 1],
            [['files'], 'file', 'maxFiles' => 10, 'maxSize' => 5 * 1024 * 1024, 'skipOnEmpty' => true],
            [['location'], 'default', 'value' => null],
        ];
    }

    /**
     * @return string|void|null
     */
    //как назвать функцию, подумать generateFullAddressLocation, тогда должно находиться не здесь
    public function checkCityInLocation()
    {
        if (!$this->hasErrors() && $this->location) {
            //как передать эту переменную в анонимную функцию
            $potentialCity = explode(' ', $this->location)[0];
            $cities = Cities::find()->select('name')->asArray()->all();
            $resultCompareCities = array_filter($cities, function ($city) : bool {
                return strpos($city['name'], explode(' ', $this->location)[0]);
            });
            return in_array(true, $resultCompareCities) ?
                $this->location :
                \Yii::$app->user->identity->userCity->name . ', ' . $this->location;
        }
    }

    /**
     * @return bool
     * @throws GuzzleException
     */
    public function isLocationExistGeocoder() : bool
    {
        return ServiceLocationPointReceive::receivePointFromYandexGeocoder($this->checkCityInLocation());
    }
}
