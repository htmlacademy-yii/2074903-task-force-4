<?php

namespace omarinina\infrastructure\models\form;

use yii\base\Model;

class TaskResponseForm extends Model
{
    /** @var null|string */
    public ?string $comment = null;

    /** @var int */
    public int $price = 0;

    public function attributeLabels()
    {
        return [
            'comment' => 'Ваш комментарий',
            'price' => 'Стоимость',
        ];
    }

    public function rules()
    {
        return [
            [['price'], 'required'],
            [['comment'], 'default', 'value' => null],
            [['price'], 'integer', 'min' => 1],
        ];
    }
}
