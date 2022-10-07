<?php
namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\user\Users;
use omarinina\domain\models\Cities;
use Yii;
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

    /** @var boolean */
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

    /**
     * @return void
     * @throws \yii\base\Exception
     */
    public function createNewUser(): void
    {
        $newUser = new Users();
        $newUser->name = $this->name;
        $newUser->email = $this->email;
        $newUser->city = $this->city;
        $newUser->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $newUser->role =  ($this->executor === true) ? 2 : 1;
        $newUser->save(false);
    }
}
