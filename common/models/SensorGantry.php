<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "gantry".
 *
 * @property string $id
 * @property string $label
 * @property string $serial
 * @property string $entry_count
 * @property string $exit_count
 * @property string $car_park_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CarPark $carPark
 */
class SensorGantry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sensor_gantry';
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
            [['label', 'car_park_id'], 'required'],
            [['car_park_id', 'entry_count', 'exit_count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['label', 'serial'], 'string', 'max' => 20]
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
            'serial' => 'Serial',
            'entry_count' => 'Entry Count',
            'exit_count' => 'Exit Count',
            'car_park_id' => 'Car Park ID',
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

    public function beforeSave($insert)
    {
        # Generate serial upon creating of "gantry"
        if($insert){
            $this->serial = SensorGantry::generateSerial();
        }else{
            if(! $this->serial) {
                $this->serial = SensorGantry::generateSerial();
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->refresh();
        parent::afterSave($insert, $changedAttributes);
    }

    private static function generateSerial($length = 32)
    {
        $security = new \yii\base\Security();
        $string = $security->generateRandomString($length);
        return $string;
    }

    public function getLatestTrafficFlow()
    {
        $sql = "SELECT n1.*
            FROM traffic_flow AS n1
            LEFT JOIN traffic_flow AS n2
              ON (n1.sensor_gantry_id = n2.sensor_gantry_id AND n1.id < n2.id)
            WHERE n2.sensor_gantry_id IS NULL AND n1.sensor_gantry_id = :sensor_gantry_id";

        $entity = TrafficFlow::findBySql($sql, ['sensor_gantry_id' => $this->id])->one();

        return $entity;
    }

}
