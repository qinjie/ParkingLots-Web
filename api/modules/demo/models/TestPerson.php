<?php
namespace api\modules\demo\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $parent_id
 * @property string $country_id
 * @property string $created_dat
 * @property string $updated_at
 */
class TestPerson extends \common\models\demo\TestPerson implements Linkable
{

    public function fields()
    {
        $fields = parent::fields();
        return $fields;
    }

    public function extraFields()
    {
        return ['country'];
    }

    /**
     * Returns a list of links.
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['test-person/view', 'id' => $this->id], true),
            'test-country' => Url::to(['test-country/view', 'id' => $this->country_id], true),
        ];
    }
}
