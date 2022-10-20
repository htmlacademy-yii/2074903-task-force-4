<?php

namespace omarinina\infrastructure\models\form;

use yii\base\Model;

class TaskResponseForm extends Model
{
    /** @var string */
    public string $comment = '';

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
            [['comment', 'price'], 'required'],
            [['comment'], 'string', 'min' => 30, 'max' => 2000],
            [['price'], 'integer', 'min' => 1],
        ];
    }
}
