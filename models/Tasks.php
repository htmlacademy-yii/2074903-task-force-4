<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property string $uuid
 * @property string|null $createAt
 * @property string $name
 * @property string|null $description
 * @property string $expiryDate
 * @property int $budget
 * @property int $categoryId
 * @property float $lat
 * @property float $lng
 * @property int $status
 *
 * @property Categories $category
 * @property Responds[] $responds
 * @property Reviews[] $reviews
 * @property TaskStatuses $status0
 * @property TaskFiles[] $taskFiles
 * @property UserTasks[] $userTasks
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'name', 'expiryDate', 'budget', 'categoryId', 'lat', 'lng', 'status'], 'required'],
            [['createAt', 'expiryDate'], 'safe'],
            [['description'], 'string'],
            [['budget', 'categoryId', 'status'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['uuid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 255],
            [['uuid'], 'unique'],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uuid' => 'Uuid',
            'createAt' => 'Create At',
            'name' => 'Name',
            'description' => 'Description',
            'expiryDate' => 'Expiry Date',
            'budget' => 'Budget',
            'categoryId' => 'Category ID',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'status' => 'Status',
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
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Responds::class, ['taskId' => 'uuid']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['taskId' => 'uuid']);
    }

    /**
     * Gets query for [[Status0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(TaskStatuses::class, ['id' => 'status']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFiles::class, ['taskId' => 'uuid']);
    }

    /**
     * Gets query for [[UserTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks()
    {
        return $this->hasMany(UserTasks::class, ['taskId' => 'uuid']);
    }
}
