<?php

namespace omarinina\domain\models\user;

use omarinina\domain\models\Cities;
use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\Reviews;
use omarinina\domain\models\task\Tasks;
use omarinina\domain\models\Categories;
use Yii;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $createAt
 * @property string $email
 * @property string $name
 * @property string $password
 * @property int $role
 * @property int $city
 * @property string|null $avatarSrc
 * @property string|null $birthDate
 * @property string|null $phone
 * @property string|null $telegram
 * @property string|null $bio
 *
 * @property Cities $userCity
 * @property Categories[] $executorCategories
 * @property Responds[] $responds
 * @property Reviews[] $clientReviews
 * @property Reviews[] $executorReviews
 * @property Roles $userRole
 * @property Tasks[] $clientTasks
 * @property Tasks[] $executorTasks
 * @property Tasks[] $executorInWorkTasks
 * @property Tasks[] $executorFailedTasks
 * @property Tasks[] $executorDoneTasks
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
            [['createAt', 'birthDate'], 'safe'],
            [['email', 'name', 'password', 'role', 'city'], 'required'],
            [['role', 'city'], 'integer'],
            [['bio', 'avatarSrc'], 'string'],
            [['email'], 'string', 'max' => 128],
            [['name', 'password'], 'string', 'max' => 255],
            [['phone', 'telegram'], 'string', 'max' => 30],
            [['email'], 'unique'],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city' => 'id']],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['role' => 'id']],
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
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'role' => 'Role',
            'city' => 'City',
            'avatarSrc' => 'Avatar Src',
            'birthDate' => 'Birth Date',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'bio' => 'Bio',
        ];
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
     * @throws InvalidConfigException
     */
    public function getExecutorCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'categoryId'])
            ->viaTable('executorCategories', ['executorId' => 'id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Responds::class, ['executorId' => 'id']);
    }

    /**
     * Gets query for [[ClientReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientReviews()
    {
        return $this->hasMany(Reviews::class, ['clientId' => 'id']);
    }

    /**
     * Gets query for [[ExecutorReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorReviews()
    {
        return $this->hasMany(Reviews::class, ['executorId' => 'id']);
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

    /**
     * Gets query for [[ClientTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientTasks()
    {
        return $this->hasMany(Tasks::class, ['clientId' => 'id']);
    }

    /**
     * Gets query for [[ExecutorTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(Tasks::class, ['executorId' => 'id']);
    }

    /**
     * Gets query for [[ExecutorInWorkTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorInWorkTasks()
    {
        return $this->getExecutorTasks()
            ->where('tasks.status = 3');
    }

    /**
     * Gets query for [[ExecutorFailedTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorFailedTasks()
    {
        return $this->getExecutorTasks()
            ->where('tasks.status = 5');
    }

    /**
     * Gets query for [[ExecutorDoneTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorDoneTasks()
    {
        return $this->getExecutorTasks()
            ->where('tasks.status = 4');
    }
}
