<?php

declare(strict_types=1);

namespace omarinina\infrastructure\models\form;

use omarinina\domain\models\Categories;
use omarinina\domain\models\user\Users;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class EditProfileForm extends Model
{
    /** @var UploadedFile|null */
    public $avatar = null;

    /** @var string */
    public string $name = '';

    /** @var string */
    public string $email = '';

    /** @var string|null */
    public ?string $birthDate = null;

    /** @var string|null */
    public ?string $phone = null;

    /** @var string|null */
    public ?string $telegram = null;

    /** @var string|null */
    public ?string $bio = null;

    /** @var array|null */
    public ?array $categories = null;

    /** @var bool */
    public bool $hidden = false;

    public function rules(): array
    {
        return [
            [['name', 'email'], 'required'],
            [['name'], 'string'],
            [['email'], 'email'],
            [['email'], 'validateEmail'],
            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 5 * 1024 * 1024],
            [['avatar', 'birthDate', 'phone', 'telegram', 'bio', 'hidden', 'categories'], 'default', 'value' => null],
            [['phone'], 'match', 'pattern' => '/^[\d]{11}/i'],
            [['telegram'], 'string', 'max' => 64],
            [['telegram'], 'match', 'pattern' => '/^@\w*$/i', 'message' => 'Телеграм должен начинаться со знака @'],
            [['bio'], 'string', 'max' => 2000],
            ['categories', 'validateCategories'],
            ['hidden', 'boolean'],
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'avatar' => 'Сменить аватар',
            'name' => 'Ваше имя',
            'email' => 'Email',
            'birthDate' => 'День рождения',
            'phone' => 'Номер телефона',
            'telegram' => 'Telegram',
            'bio' => 'Информация о себе',
            'categories' => '',
            'hidden' => 'показывать мои контакты только заказчикам, по заданиям которых работаю'
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;

            if (Users::findOne(['email' => $this->email]) && $user->email !== $this->email) {
                $this->addError($attribute, 'На данный email уже зарегистрирован пользователь');
            }
        }
    }

    public function validateCategories($attribute, $params)
    {
        if (!$this->hasErrors()) {
            foreach ($this->categories as $categoryId) {
                if (!Categories::findOne($categoryId)) {
                    $this->addError($attribute, 'Такой категории не существует');
                }
            }
        }
    }
}
