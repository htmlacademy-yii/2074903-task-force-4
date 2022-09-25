<?php

namespace omarinina\domain\models;

use Yii;
use omarinina\domain\models\task\Tasks;
use omarinina\domain\models\user\Users;

/**
 * This is the model class for table "userTasks".
 *
 * @property int $id
 * @property string $userId
 * @property string $taskId
 *
 * @property Tasks $task
 * @property Users $user
 */
class UserTasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userTasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'taskId'], 'required'],
            [['userId', 'taskId'], 'string', 'max' => 36],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['userId' => 'uuid']],
            [['taskId'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['taskId' => 'uuid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'taskId' => 'Task ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['uuid' => 'taskId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['uuid' => 'userId']);
    }
}
