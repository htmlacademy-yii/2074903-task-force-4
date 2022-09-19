<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $uuid
 * @property string|null $createAt
 * @property string $email
 * @property string $name
 * @property string $password
 * @property int $role
 * @property int $city
 *
 * @property Cities $city0
 * @property ExecutorCategories[] $executorCategories
 * @property ExecutorProfiles $executorProfiles
 * @property Responds[] $responds
 * @property Reviews[] $reviews
 * @property Reviews[] $reviews0
 * @property Roles $role0
 * @property UserTasks[] $userTasks
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'email', 'name', 'password', 'role', 'city'], 'required'],
            [['createAt'], 'safe'],
            [['role', 'city'], 'integer'],
            [['uuid'], 'string', 'max' => 36],
            [['email'], 'string', 'max' => 128],
            [['name', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['uuid'], 'unique'],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['role' => 'id']],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city' => 'id']],
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
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'role' => 'Role',
            'city' => 'City',
        ];
    }

    /**
     * Gets query for [[City0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity0()
    {
        return $this->hasOne(Cities::class, ['id' => 'city']);
    }

    /**
     * Gets query for [[ExecutorCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorCategories()
    {
        return $this->hasMany(ExecutorCategories::class, ['executorId' => 'uuid']);
    }

    /**
     * Gets query for [[ExecutorProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorProfiles()
    {
        return $this->hasOne(ExecutorProfiles::class, ['executorId' => 'uuid']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Responds::class, ['executorId' => 'uuid']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['executorId' => 'uuid']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Reviews::class, ['clientId' => 'uuid']);
    }

    /**
     * Gets query for [[Role0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(Roles::class, ['id' => 'role']);
    }

    /**
     * Gets query for [[UserTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks()
    {
        return $this->hasMany(UserTasks::class, ['userId' => 'uuid']);
    }
}
