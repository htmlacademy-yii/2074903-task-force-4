<?php

declare(strict_types=1);

namespace omarinina\domain\models\task;

use omarinina\domain\models\user\Users;
use Yii;
use omarinina\domain\traits\TimeCounter;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $taskId
 * @property int $executorId
 * @property int $clientId
 * @property int $score
 * @property string|null $comment
 * @property string $createAt
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
            [['taskId', 'executorId', 'clientId', 'score'], 'integer'],
            [['comment'], 'string'],
            [['createAt'], 'safe'],
            [['clientId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['clientId' => 'id']],
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
            'clientId' => 'Client ID',
            'score' => 'Score',
            'comment' => 'Comment',
            'createAt' => 'Create At',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Users::class, ['id' => 'clientId']);
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

    use TimeCounter;
}
