<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "car_park".
 *
 * @property string $id
 * @property string $label
 * @property int $lot_capacity
 * @property int $car_count
 * @property string $serial
 * @property string $user_id
 * @property string $status
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $owner
 * @property SensorGantry[] $gantries
 */
class CarPark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_park';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                // Modify only created not updated attribute
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => null,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'lot_capacity'], 'required'],
            [['lot_capacity', 'car_count', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['label'], 'string', 'max' => 50],
            [['serial'], 'string', 'max' => 32],
            [['remark'], 'string', 'max' => 100]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'lot_capacity' => 'Lot Capacity',
            'car_count' => 'Car Count',
            'serial' => 'Serial',
            'user_id' => 'Owner',
            'status' => 'Status',
            'remark' => 'Remark',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGantries()
    {
        return $this->hasMany(SensorGantry::className(), ['car_park_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->refresh();
        parent::afterSave($insert, $changedAttributes);
    }

    public function getLatestTrafficFlow()
    {
        $sql = "SELECT n1.*
            FROM traffic_flow AS n1
            LEFT JOIN traffic_flow AS n2
              ON (n1.car_park_id = n2.car_park_id AND n1.id < n2.id)
            WHERE n2.car_park_id IS NULL AND n1.car_park_id = :car_park_id";

        $entity = TrafficFlow::findBySql($sql, ['car_park_id' => $this->id])->one();

        return $entity;
    }

}
