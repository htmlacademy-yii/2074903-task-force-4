<?php

namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\Categories;
use yii\base\Model;

class CreateTaskForm extends Model
{
    /** @var string */
    public string $name = '';

    /** @var string */
    public string $description = '';

    /** @var int */
    public int $categoryId;

    /** @var int|null */
    public ?int $cityId = null;

    /** @var string */
    public string $budget = '';

    /** @var string */
    public string $expiryDate = '';

    /** @var array */
    public array $files = [];

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'categoryId' => 'Категория',
            'cityId' => 'Локация',
            'budget' => 'Бюджет',
            'expiryDate' => 'Срок исполнения',
            'files' => 'Файлы'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'cityId', 'categoryId', 'budget'], 'safe'],
            [['name', 'budget', 'categoryId', 'description'], 'required'],
            [['name'], 'min' => 10, 'max' => 255],
            [['description'], 'min' => 30, 'max' => 2000],
            [['categoryId'], 'exist', 'targetClass' => Categories::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['cityId', 'expiryDate'], 'default' => null],
            [['budget'], 'integer', 'min' => 1],
            [['files'], 'file', 'multiple' => true, 'maxFiles' => 10, 'maxSize' => 5 * 1024 * 1024],
        ];
    }
}
