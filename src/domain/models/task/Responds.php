<?php

namespace omarinina\domain\models\task;

use omarinina\domain\models\user\Users;
use Yii;
use omarinina\domain\traits\CountTime;

/**
 * This is the model class for table "responds".
 *
 * @property int $id
 * @property int $taskId
 * @property int $executorId
 * @property string $createAt
 * @property string $price
 * @property string|null $comment
 *
 * @property Users $executor
 * @property Tasks $task
 */
class Responds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taskId', 'executorId', 'price'], 'required'],
            [['taskId', 'executorId'], 'integer'],
            [['createAt'], 'safe'],
            [['comment'], 'string'],
            [['price'], 'string', 'max' => 128],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['executorId' => 'id']],
            [['taskId'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['taskId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'taskId' => 'Task ID',
            'executorId' => 'Executor ID',
            'createAt' => 'Create At',
            'price' => 'Price',
            'comment' => 'Comment',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::class, ['id' => 'executorId']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'taskId']);
    }

    use CountTime;
}
