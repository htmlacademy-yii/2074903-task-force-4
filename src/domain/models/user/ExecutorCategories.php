<?php

namespace omarinina\domain\models\user;

use Yii;
use omarinina\domain\models\Categories;

/**
 * This is the model class for table "executorCategories".
 *
 * @property int $id
 * @property int $categoryId
 * @property string $executorId
 *
 * @property Categories $category
 * @property Users $executor
 */
class ExecutorCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executorCategories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoryId', 'executorId'], 'required'],
            [['categoryId'], 'integer'],
            [['executorId'], 'string', 'max' => 36],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['categoryId' => 'id']],
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
            'categoryId' => 'Category ID',
            'executorId' => 'Executor ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'categoryId']);
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
}
