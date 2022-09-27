<?php

namespace omarinina\domain\models\user;

use Yii;

/**
 * This is the model class for table "executorStatuses".
 *
 * @property int $id
 * @property string $executorStatus
 *
 * @property ExecutorProfiles $executorProfiles
 */
class ExecutorStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executorStatuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executorStatus'], 'required'],
            [['executorStatus'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'executorStatus' => 'Executor Status',
        ];
    }

    /**
     * Gets query for [[ExecutorProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorProfiles()
    {
        return $this->hasMany(ExecutorProfiles::class, ['status' => 'id']);
    }
}
