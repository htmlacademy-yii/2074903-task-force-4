<?php

declare(strict_types=1);

namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\user\Users;
use omarinina\domain\models\Cities;
use yii\base\Model;

class RegistrationForm extends Model
{
    /** @var string */
    public string $name = '';

    /** @var string */
    public string $email = '';

    /** @var int */
    public int $city = 0;

    /** @var string */
    public string $password = '';

    /** @var string */
    public string $repeatedPassword = '';

    /** @var bool */
    public bool $executor = false;

    public function rules(): array
    {
        return [
            [['name', 'email', 'city', 'password', 'repeatedPassword', 'executor'], 'required'],
            ['name', 'string'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => Users::class, 'message' => 'Пользователь с таким e-mail уже существует'],
            ['city', 'exist', 'targetClass' => Cities::class, 'targetAttribute' => ['city' => 'id']],
            ['password', 'string', 'min' => 8],
            ['repeatedPassword', 'compare', 'compareAttribute' => 'password'],
            ['executor', 'boolean']
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Город',
            'password' => 'Пароль',
            'repeatedPassword' => 'Повтор пароля',
            'executor' => 'я собираюсь откликаться на заказы'
        ];
    }
}
