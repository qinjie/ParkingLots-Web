<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $label
 * @property string $file_name
 * @property string $file_type
 * @property string $file_size
 * @property string $car_park_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CarPark $carPark
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_size', 'car_park_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['label'], 'string', 'max' => 20],
            [['file_name'], 'string', 'max' => 50],
            [['file_type'], 'string', 'max' => 10]
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
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'car_park_id' => 'Car Park',
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
}
