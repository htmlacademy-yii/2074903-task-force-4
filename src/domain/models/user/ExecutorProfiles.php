<?php

namespace omarinina\domain\models\user;

use omarinina\domain\models\Categories;
use Yii;

/**
 * This is the model class for table "executorProfiles".
 *
 * @property string $executorId
 * @property string|null $avatarSrc
 * @property string|null $birthDate
 * @property string|null $phone
 * @property string|null $telegram
 * @property string|null $bio
 * @property int $status
 *
 * @property Users $executor
 * @property ExecutorStatuses $executorStatus
 * @property Categories $categories
 */
class ExecutorProfiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executorProfiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executorId', 'status'], 'required'],
            [['birthDate'], 'safe'],
            [['bio'], 'string'],
            [['status'], 'integer'],
            [['executorId'], 'string', 'max' => 36],
            [['avatarSrc', 'phone', 'telegram'], 'string', 'max' => 255],
            [['executorId'], 'unique'],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['executorId' => 'uuid']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => ExecutorStatuses::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'executorId' => 'Executor ID',
            'avatarSrc' => 'Avatar Src',
            'birthDate' => 'Birth Date',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'bio' => 'Bio description',
            'status' => 'Status',
        ];
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

    /**
     * Gets query for [[ExecutorStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorStatus()
    {
        return $this->hasOne(ExecutorStatuses::class, ['id' => 'status']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'categoryId'])
            ->viaTable('executorCategories', ['executorId' => 'executorId']);
    }
}
