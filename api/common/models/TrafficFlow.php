<?php
namespace api\common\models;

use Yii;

class TrafficFlow extends \common\models\TrafficFlow
{
    public function extraFields()
    {
        $more = ['car-park', 'sensor-gantry'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }

}
