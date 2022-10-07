<?php
namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\user\Users;
use omarinina\domain\models\Cities;
use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;

class RegistrationForm extends Model implements IdentityInterface
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

    /** @var Users */
    private Users $newUser;

    /**
     * @return Users
     */
    private function getNewUser(): Users
    {
        return $this->newUser = new Users();
    }

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
        $this->newUser->name = $this->name;
        $this->newUser->email = $this->email;
        $this->newUser->city = $this->city;
        $this->newUser->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->newUser->role =  ($this->executor === true) ? 2 : 1;
        $this->newUser->save(false);
    }

    public static function findIdentity($id)
    {
        return Users::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->newUser->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}