<?php
namespace api\modules\demo\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class TestCountry extends \common\models\demo\TestCountry implements Linkable
{
    public function fields()
    {
        $fields = parent::fields();
        return $fields;
    }

    public function extraFields()
    {
        return ['user', 'persons'];
    }

    /**
     * Returns a list of links.
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['test-country/view', 'id' => $this->id], true),
            'owner' => Url::to(['user/view', 'id' => $this->user_id], true),
        ];
    }

    public function beforeSave($insert)
    {
        // Use current login user's ID if userId is null
        if ($this->user_id == null) {
            $this->user_id = Yii::$app->user->identity->getId();
        }
        return parent::beforeSave($insert);
    }
}