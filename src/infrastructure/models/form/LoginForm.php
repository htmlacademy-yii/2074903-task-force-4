<?php

declare(strict_types=1);

namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\user\Users;
use yii\base\Model;
use Yii;

class LoginForm extends Model
{
    /** @var string */
    public string $email = '';

    /** @var string */
    public string $password = '';

    /** @var Users|null */
    private ?Users $user = null;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return Users|null
     */
    public function getUser(): ?Users
    {
        if ($this->user === null) {
            $email = mb_strtolower($this->email);
            $this->user = Users::findOne(['email' => $email]);
        }

        return $this->user;
    }

    /**
     * @param $attribute
     * @param $params
     * @return void
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }
}
