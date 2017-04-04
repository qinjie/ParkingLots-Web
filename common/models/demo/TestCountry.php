<?php

namespace common\models\demo;

use Yii;

/**
 * This is the model class for table _test_country".
 *
 * @property string $code
 * @property string $name
 * @property integer $population
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 */
class TestCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '_test_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['population'], 'integer'],
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 52]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'population' => 'Population',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['code'];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->refresh();
        parent::afterSave($insert, $changedAttributes);
    }
}
