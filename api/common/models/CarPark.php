<?php
namespace api\common\models;

use Yii;

class CarPark extends \common\models\CarPark
{
    public function extraFields()
    {
        $more = ['gantries','owner', 'latest-traffic-flow'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }

}
