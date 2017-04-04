<?php
namespace api\common\models;

use Yii;

class SensorGantry extends \common\models\SensorGantry
{
    public function extraFields()
    {
        $more = ['carPark', 'latest-traffic-flow'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }

}
