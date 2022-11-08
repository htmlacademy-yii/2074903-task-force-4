<?php

declare(strict_types=1);

namespace omarinina\domain\models;

use omarinina\domain\models\task\TaskFiles;
use omarinina\domain\models\task\Tasks;
use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $fileSrc
 *
 * @property TaskFiles $taskFile
 * @property Tasks $task
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fileSrc'], 'required'],
            [['fileSrc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fileSrc' => 'File Src',
        ];
    }

    /**
     * Gets query for [[TaskFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFile()
    {
        return $this->hasOne(TaskFiles::class, ['fileId' => 'id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'taskId'])
            ->viaTable('taskFiles', ['fileId' => 'id']);
    }
}
