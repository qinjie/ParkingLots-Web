<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "traffic_flow".
 *
 * @property string $id
 * @property string $sensor_gantry_id
 * @property boolean $direction
 * @property string $entry_count
 * @property string $exit_count
 * @property string $car_park_id
 * @property string $car_count
 * @property string $empty_lot
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CarPark $carPark
 * @property SensorGantry $sensorGantry
 */
class TrafficFlow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traffic_flow';
    }

    const CAR_EXIT = 0;
    const CAR_ENTRY = 1;

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
                'createdByAttribute' => null,
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
            [['sensor_gantry_id', 'car_park_id'], 'required'],
            [['sensor_gantry_id', 'entry_count', 'exit_count',
                'car_park_id', 'car_count', 'empty_lot'], 'integer'],
            [['direction'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sensor_gantry_id' => 'Sensor Gantry ID',
            'direction' => 'Direction',
            'entry_count' => 'Entry Count',
            'exit_count' => 'Exit Count',
            'car_park_id' => 'Car Park ID',
            'car_count' => 'Car Count',
            'empty_lot' => 'Empty Lots',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarPark()
    {
        return $this->hasOne(CarPark::className(), ['id' => 'car_park_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSensorGantry()
    {
        return $this->hasOne(SensorGantry::className(), ['id' => 'sensor_gantry_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->refresh();
        parent::afterSave($insert, $changedAttributes);
    }

}
