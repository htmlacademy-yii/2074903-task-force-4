<?php

namespace omarinina\infrastructure\models\form;

use yii\base\Model;

class TaskResponseForm extends Model
{
    /** @var null|string */
    public ?string $comment = null;

    /** @var null|string */
    public ?string $price = null;

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
            [['comment'], 'string', 'min' => 30, 'max' => 2000],
            [['price'], 'integer', 'min' => 1],
        ];
    }
}