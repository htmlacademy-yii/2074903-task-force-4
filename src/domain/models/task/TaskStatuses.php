<?php

declare(strict_types=1);

namespace omarinina\domain\models\task;

use Yii;

/**
 * This is the model class for table "taskStatuses".
 *
 * @property int $id
 * @property string $taskStatus
 * @property string $name
 *
 * @property Tasks[] $tasks
 * @property Tasks[] $newTasks
 */
class TaskStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taskStatuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taskStatus', 'name'], 'required'],
            [['taskStatus', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'taskStatus' => 'Task Status',
            'name' => 'Russian name Status'
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['status' => 'id']);
    }

    /**
     * Gets query for [[NewTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewTasks()
    {
        return $this->hasMany(Tasks::class, ['status' => 'id'])
            ->where('expiryDate' > new \yii\db\Expression('NOW()'))
            ->orderBy('createAt DESC');
    }
}
