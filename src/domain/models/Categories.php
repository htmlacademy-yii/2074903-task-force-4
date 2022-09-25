<?php

namespace omarinina\domain\models;

use omarinina\domain\models\user\ExecutorProfiles;
use Yii;
use omarinina\domain\models\user\Users;
use omarinina\domain\models\task\Tasks;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $icon
 *
 * @property ExecutorProfiles $executorProfiles
 * @property Users $executors
 * @property Tasks $tasks
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon src',
        ];
    }

//    /**
//     * Gets query for [[ExecutorCategories]].
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public function getExecutorCategories()
//    {
//        return $this->hasMany(ExecutorCategories::class, ['categoryId' => 'id']);
//    }

    /**
     * Gets query for [[ExecutorProfiles]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getExecutorProfiles()
    {
        return $this->hasMany(ExecutorProfiles::class, ['executorId' => 'executorId'])
            ->viaTable('executorCategories', ['categoriesId' => 'id']);
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getExecutors()
    {
        return $this->hasMany(Users::class, ['uuid' => 'executorId'])
            ->viaTable('executorCategories', ['categoriesId' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['categoryId' => 'id']);
    }
}
