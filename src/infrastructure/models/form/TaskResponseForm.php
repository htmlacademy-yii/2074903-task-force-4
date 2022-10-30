<?php

namespace omarinina\infrastructure\models\form;

use omarinina\infrastructure\constants\TaskStatusConstants;
use omarinina\infrastructure\constants\UserRoleConstants;
use yii\base\Model;
use omarinina\domain\models\task\Tasks;
use omarinina\domain\models\user\Users;

class TaskResponseForm extends Model
{
    /** @var null|string */
    public ?string $comment = null;

    /** @var int */
    public int $price = 0;

    public function attributeLabels()
    {
        return [
            'comment' => 'Ваш комментарий',
            'price' => 'Стоимость',
        ];
    }

    public function rules()
    {
        return [
            [['price'], 'required'],
            [['comment'], 'default', 'value' => null],
            [['price'], 'integer', 'min' => 1],
        ];
    }

    /**
     * @param Users $user
     * @param Tasks $task
     * @return bool
     */
    public function isAvailableAddRespond(Users $user, Tasks $task) : bool
    {
        if ($user->role === UserRoleConstants::ID_EXECUTOR_ROLE &&
            !$user->getResponds()->where(['taskId' => $task->id])->one() &&
            $task->status = TaskStatusConstants::ID_NEW_STATUS) {
            return true;
        }
        return false;
    }
}
