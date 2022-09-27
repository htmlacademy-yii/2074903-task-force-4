<?php

namespace omarinina\domain\models\user;

use omarinina\domain\models\Categories;
use omarinina\domain\valueObjects\UniqueIdentification;
use Yii;
use omarinina\domain\models\Cities;
use omarinina\domain\models\task\Responds;
use omarinina\domain\models\Reviews;
use omarinina\domain\models\task\Tasks;
use yii\db\Expression;

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
 * @property Cities $userCity
 * @property ExecutorCategories $executorCategories
 * @property Categories $categories
 * @property ExecutorProfiles $executorProfiles
 * @property Responds $responds
 * @property Reviews $executorReviews
 * @property Reviews $clientReviews
 * @property Roles $userRole
 * @property Tasks $tasks
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
     * Gets query for [[UserCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCity()
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
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'categoriesId'])
            ->viaTable('executorCategories', ['executorId' => 'uuid']);
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
     * Gets query for [[ExecutorReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorReviews()
    {
        return $this->hasMany(Reviews::class, ['executorId' => 'uuid']);
    }

    /**
     * Gets query for [[ClientReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientReviews()
    {
        return $this->hasMany(Reviews::class, ['clientId' => 'uuid']);
    }

    /**
     * Gets query for [[UserRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(Roles::class, ['id' => 'role']);
    }

//    /**
//     * Gets query for [[UserTasks]].
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public function getUserTasks()
//    {
//        return $this->hasMany(UserTasks::class, ['userId' => 'uuid']);
//    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['id' => 'taskId'])
            ->viaTable('userTasks', ['userId' => 'uuid']);
    }
}
