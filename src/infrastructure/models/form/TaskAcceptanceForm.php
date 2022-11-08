<?php

declare(strict_types=1);

namespace omarinina\infrastructure\models\form;

use yii\base\Model;

class TaskAcceptanceForm extends Model
{
    /** @var null|string */
    public ?string $comment = null;

    /** @var int */
    public int $score = 0;

    public function attributeLabels()
    {
        return [
            'comment' => 'Ваш комментарий',
            'score' => 'Оценка работы',
        ];
    }

    public function rules()
    {
        return [
            [['score'], 'required'],
            [['comment'], 'default', 'value' => null],
            [['score'], 'integer', 'min' => 1, 'max' => 5],
        ];
    }
}
