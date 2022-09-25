<?php

namespace omarinina\domain\models\task;

use Yii;
use omarinina\domain\valueObjects\UniqueIdentification;
use omarinina\domain\models\Categories;
use omarinina\domain\models\Reviews;
use omarinina\domain\models\user\Users;
use omarinina\domain\models\Files;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property string $uuid
 * @property string $createAt
 * @property string $name
 * @property string|null $description
 * @property string $expiryDate
 * @property int $budget
 * @property int $categoryId
 * @property float|null $lat
 * @property float|null $lng
 * @property int $status
 *
 * @property Categories $category
 * @property Responds $responds
 * @property Reviews $reviews
 * @property TaskStatuses $taskStatus
 * @property Files $files
 * @property Users $users
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
            [['uuid', 'name', 'expiryDate', 'budget', 'categoryId', 'status', 'createAt'], 'required'],
            [['createAt', 'expiryDate'], 'safe'],
            [['createAt'], 'default', 'value' => new Expression('NOW()')],
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
            'lat' => 'Latitude',
            'lng' => 'Longitude',
            'status' => 'Status',
        ];
    }

    /**
     * @return UniqueIdentification
     */
    public function getUuidString(): UniqueIdentification
    {
        return new UniqueIdentification($this->uuid);
    }

    /**
     * @param UniqueIdentification $value
     * @return void
     */
    public function setUuidString(UniqueIdentification $value): void
    {
        $this->uuid = $value->getId();
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
     * Gets query for [[TaskStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskStatus()
    {
        return $this->hasOne(TaskStatuses::class, ['id' => 'status']);
    }

//    /**
//     * Gets query for [[TaskIdFiles]].
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public function getTaskIdFiles()
//    {
//        return $this->hasMany(TaskFiles::class, ['taskId' => 'uuid']);
//    }

    /**
     *  Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFiles()
    {
        return $this->hasMany(Files::class, ['id' => 'fileId'])
            ->viaTable('taskFiles', ['taskId' => 'uuid']);
    }

//    /**
//     * Gets query for [[UserTasks]].
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public function getUserTasks()
//    {
//        return $this->hasMany(UserTasks::class, ['taskId' => 'uuid']);
//    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'userId'])
            ->viaTable('userTasks', ['taskId' => 'uuid']);
    }
}
