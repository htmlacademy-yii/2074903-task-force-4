<?php

declare(strict_types=1);

namespace omarinina\infrastructure\models\form;

use yii\base\Model;
use Yii;
use yii\web\NotFoundHttpException;

class SecurityProfileForm extends Model
{
    /** @var string */
    public string $currentPassword = '';

    /** @var string */
    public string $newPassword = '';

    /** @var string */
    public string $repeatedPassword = '';

    public function rules(): array
    {
        return [
            [['currentPassword', 'newPassword', 'repeatedPassword'], 'required'],
            ['currentPassword', 'validateCurrentPassword'],
            ['newPassword', 'string', 'min' => 8],
            ['repeatedPassword', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'currentPassword' => 'Ваш текущий пароль',
            'newPassword' => 'Новый пароль',
            'repeatedPassword' => 'Повтор пароля',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return void
     * @throws NotFoundHttpException
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;

            if (!$user) {
                throw new NotFoundHttpException('User is not found', 404);
            }

            if (!Yii::$app->security->validatePassword($this->currentPassword, $user->password)) {
                $this->addError($attribute, 'Неправильный пароль');
            }
        }
    }
}
