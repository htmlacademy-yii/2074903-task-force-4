<?php

namespace omarinina\domain\models\task;

use omarinina\domain\models\Cities;
use omarinina\domain\models\user\Users;
use omarinina\domain\models\Categories;
use omarinina\domain\models\Files;
use Yii;
use omarinina\domain\traits\CountTime;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $createAt
 * @property string $name
 * @property string|null $description
 * @property string $expiryDate
 * @property string $budget
 * @property int $categoryId
 * @property int $cityId
 * @property int $status
 * @property int|null $executorId
 * @property int $clientId
 *
 * @property Categories $category
 * @property Users $client
 * @property Users $executor
 * @property Responds[] $responds
 * @property Reviews $review
 * @property TaskStatuses $taskStatus
 * @property TaskFiles[] $taskFiles
 * @property Files[] $files
 * @property Cities $city
 *
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
            [['createAt', 'expiryDate'], 'safe'],
            [['name', 'expiryDate', 'budget', 'categoryId', 'status', 'clientId'], 'required'],
            [['description'], 'string'],
            [['categoryId', 'status', 'executorId', 'clientId', 'cityId'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['budget'], 'string', 'max' => 128],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['clientId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['clientId' => 'id']],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['executorId' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createAt' => 'Create At',
            'name' => 'Name',
            'description' => 'Description',
            'expiryDate' => 'Expiry Date',
            'budget' => 'Budget',
            'categoryId' => 'Category ID',
            'cityId' => 'City ID',
            'status' => 'Status',
            'executorId' => 'Executor ID',
            'clientId' => 'Client ID',
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
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Responds::class, ['taskId' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Reviews::class, ['taskId' => 'id']);
    }

    /**
     * Gets query for [[TaskStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskStatus()
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
        return $this->hasMany(TaskFiles::class, ['taskId' => 'id']);
    }

    /**
     *  Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFiles()
    {
        return $this->hasMany(Files::class, ['id' => 'fileId'])
            ->viaTable('taskFiles', ['taskId' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'cityId']);
    }

    use CountTime;

}
