<?php

namespace common\models\demo;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $parent_id
 * @property string $country_id
 * @property string $created_dat
 * @property string $updated_at
 *
 * @property TestCountry $country
 */
class TestPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '_test_person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['parent_id', 'country_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'parent_id' => 'Parent ID',
            'country_id' => 'Country ID',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            /* Custom attribute labels */
            'full_name' => Yii::t('app', 'Full Name')
        ];
    }

    /* Getter for person full name */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(TestCountry::className(), ['id' => 'country_id']);
    }
}
