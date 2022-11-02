<?php

namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\user\Users;
use yii\base\Model;
use Yii;

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

    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;

            if (!$user || !Yii::$app->security->validatePassword($this->currentPassword, $user->password)) {
                $this->addError($attribute, 'Неправильный пароль');
            }
        }
    }
}
