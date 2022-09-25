<?php

namespace omarinina\domain\models;

use Yii;
use omarinina\domain\models\user\Users;
use omarinina\domain\models\task\Tasks;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $taskId
 * @property string $executorId
 * @property string $clientId
 * @property int $score
 * @property string|null $comment
 * @property string|null $createAt
 * @property int|null $success
 *
 * @property Users $client
 * @property Users $executor
 * @property Tasks $task
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taskId', 'executorId', 'clientId', 'score'], 'required'],
            [['score', 'success'], 'integer'],
            [['comment'], 'string'],
            [['createAt'], 'safe'],
            [['taskId', 'executorId', 'clientId'], 'string', 'max' => 36],
            [['taskId'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['taskId' => 'uuid']],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['executorId' => 'uuid']],
            [['clientId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['clientId' => 'uuid']],
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
            'clientId' => 'Client ID',
            'score' => 'Score',
            'comment' => 'Comment',
            'createAt' => 'Create At',
            'success' => 'Success',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Users::class, ['uuid' => 'clientId']);
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
