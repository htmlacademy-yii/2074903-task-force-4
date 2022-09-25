<?php

namespace omarinina\domain\models;

use Yii;
use omarinina\domain\models\task\Tasks;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $fileSrc
 *
 * @property Tasks $tasks
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
            [['fileSrc'], 'string', 'max' => 255],
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

//    /**
//     * Gets query for [[TaskFiles]].
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public function getTaskFiles()
//    {
//        return $this->hasMany(TaskFiles::class, ['fileId' => 'id']);
//    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['uuid' => 'taskId'])
            ->viaTable('taskFiles', ['fileId' => 'id']);
    }
}
