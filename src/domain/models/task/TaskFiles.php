<?php

declare(strict_types=1);

namespace omarinina\domain\models\task;

use omarinina\domain\models\Files;

/**
 * This is the model class for table "taskFiles".
 *
 * @property int $id
 * @property int $fileId
 * @property int $taskId
 *
 * @property Files $file
 * @property Tasks $task
 */
class TaskFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taskFiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fileId', 'taskId'], 'required'],
            [['fileId', 'taskId'], 'integer'],
            [['taskId'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['taskId' => 'id']],
            [['fileId'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['fileId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fileId' => 'File ID',
            'taskId' => 'Task ID',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::class, ['id' => 'fileId']);
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
}
