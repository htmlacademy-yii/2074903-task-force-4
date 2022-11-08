<?php

declare(strict_types=1);

namespace omarinina\infrastructure\models\form;

use GuzzleHttp\Exception\GuzzleException;
use omarinina\application\services\location\interfaces\GeoObjectReceiveInterface;
use omarinina\application\services\location\pointReceive\GeoObjectReceiveService;
use omarinina\domain\models\Categories;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Yii;
use DateTime;

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
            [['expiryDate'], 'validateExpiryDate'],
            [['budget'], 'integer', 'min' => 1],
            [['files'], 'file', 'maxFiles' => 10, 'maxSize' => 5 * 1024 * 1024, 'skipOnEmpty' => true],
            [['location'], 'default', 'value' => null],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return void
     * @throws \yii\base\InvalidConfigException
     */
    public function validateExpiryDate($attribute, $params) : void
    {
        if (!$this->hasErrors()) {
            if (Yii::$app->formatter->asDatetime($this->expiryDate, 'php:Y-m-d') <
                Yii::$app->formatter->asDatetime(new DateTime('now'), 'php:Y-m-d')) {
                $this->addError($attribute, 'Дата исполнения не может быть раньше сегодняшнего дня');
            }
        }
    }

    /**
     * @return bool
     * @throws InvalidConfigException
     */
    public function isLocationExistGeocoder() : bool
    {
        return (bool)Yii::$container
            ->get(GeoObjectReceiveInterface::class)
            ->receiveGeoObjectFromYandexGeocoder($this->location);
    }
}
