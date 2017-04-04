<?php
namespace api\modules\demo\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class TestPost extends \common\models\demo\TestPost implements Linkable
{

    public function fields()
    {
        $fields = parent::fields();
        return $fields;
    }

    public function extraFields()
    {
        return ['user'];
    }

    /**
     * Returns a list of links.
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['test-post/view', 'id' => $this->id], true),
            'owner' => Url::to(['user/view', 'id' => $this->user_id], true),
        ];
    }
}
