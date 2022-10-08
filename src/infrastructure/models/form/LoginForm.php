<?php
namespace omarinina\infrastructure\models\form;

use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user;

    
}
