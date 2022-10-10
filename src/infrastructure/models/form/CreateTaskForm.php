<?php

namespace omarinina\infrastructure\models\form;

use yii\base\Model;

class CreateTaskForm extends Model
{
    public $name;
    public $description;
    public $categoryId;
    public $cityId;
    public $budget;
    public $expiryDate;
    public $files[];
}
