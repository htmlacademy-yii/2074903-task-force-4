<?php
namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\Cities;
use yii\base\Model;

class RegistrationCityRoleForm extends Model
{
    /** @var int */
    public int $city = 0;

    /** @var bool */
    public bool $executor = false;

    public function rules(): array
    {
        return [
            [['city', 'executor'], 'required'],
            ['city', 'exist', 'targetClass' => Cities::class, 'targetAttribute' => ['city' => 'id']],
            ['executor', 'boolean']
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'city' => 'Город',
            'executor' => 'я собираюсь откликаться на заказы'
        ];
    }
}
