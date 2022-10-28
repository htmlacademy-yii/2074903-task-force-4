<?php
namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\Cities;
use yii\base\Model;

class RegistrationRoleForm extends Model
{
    /** @var bool */
    public bool $executor = false;

    public function rules(): array
    {
        return [
            [['executor'], 'required'],
            ['executor', 'boolean']
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'executor' => 'я собираюсь откликаться на заказы'
        ];
    }
}
