<?php

namespace omarinina\domain\models;

use Yii;
use omarinina\domain\models\user\Users;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $name
 * @property float $lat
 * @property float $lng
 *
 * @property Users $users
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lat', 'lng'], 'required'],
            [['lat', 'lng'], 'number'],
            [['name'], 'string', 'max' => 128],
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
            'lat' => 'Latitude',
            'lng' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['city' => 'id']);
    }
}
