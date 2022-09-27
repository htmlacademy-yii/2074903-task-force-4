<?php

namespace omarinina\domain\models\task;

use Yii;
use yii\db\Expression;
use omarinina\domain\models\user\Users;


/**
 * This is the model class for table "responds".
 *
 * @property int $id
 * @property string $taskId
 * @property string $executorId
 * @property string|null $createAt
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
            [['createAt'], 'safe'],
            [['price'], 'string', 'max' => 128],
            [['comment'], 'string'],
            [['taskId', 'executorId'], 'string', 'max' => 36],
            [['taskId'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['taskId' => 'uuid']],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['executorId' => 'uuid']],
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
        return $this->hasOne(Users::class, ['uuid' => 'executorId']);
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
}
