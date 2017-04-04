<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 29/3/15
 * Time: 17:58
 */

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\models\TrafficFlow;
use common\models\CarPark;
use common\models\SensorGantry;
use Yii;
use \yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class TrafficFlowController extends CustomActiveController
{
    public $modelClass = 'api\common\models\TrafficFlow';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view', 'search',
            'latest-by-car-park', 'latest-all-car-park',
            'latest-all-car-park-today', 'list-older-than-hours',
            'car-entry', 'car-exit'];
        $behaviors['access']['rules'] = [
            [   // No authentication required
                'actions' => ['view', 'search',
                    'latest-by-car-park', 'latest-all-car-park',
                    'latest-all-car-park-today', 'list-older-than-hours',
                    'car-entry', 'car-exit'],
                'allow' => true,
                'roles' => ['?', '@'],
            ],
            [ # all other actions are matched by RBAC rules
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    $module = Yii::$app->controller->module->id;
                    $action = Yii::$app->controller->action->id;
                    $controller = Yii::$app->controller->id;
                    $route = "$module/$controller/$action";
                    $post = Yii::$app->request->post();
                    if (Yii::$app->user->can($route)) {
                        return true;
                    }
                    return false;
                }
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
//        unset($actions['delete']);
        unset($actions['update']);
        return $actions;
    }

    public function actionCarEntry($gantry_serial)
    {
        /* @var $gantry \common\models\SensorGantry */
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $gantry = SensorGantry::findOne(['serial' => $gantry_serial]);
            if (!$gantry) {
                throw new NotFoundHttpException("Failed to find gantry with serial = $gantry_serial");
            } else {
                SensorGantry::getDb()->transaction(function ($db) use ($gantry) {
                    $gantry->entry_count++;
                    if (!$gantry->save())
                        throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                });
            }

            $car_park = $gantry->carPark;
            CarPark::getDb()->transaction(function ($db) use ($car_park) {
                $car_park->car_count++;
                if (!$car_park->save())
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            });

            $traffic = new TrafficFlow();
            $traffic->sensor_gantry_id = $gantry->id;
            $traffic->entry_count = $gantry->entry_count;
            $traffic->exit_count = $gantry->exit_count;
            $traffic->direction = TrafficFlow::CAR_ENTRY;
            $traffic->car_park_id = $car_park->id;
            $traffic->car_count = $car_park->car_count;
            $traffic->empty_lot = max(0, $car_park->lot_capacity - $car_park->car_count);
            if ($traffic->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
            } elseif (!$traffic->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            $transaction->commit();
            return $traffic;

        } catch (Exception $e) {
            $transaction->rollBack();
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }

    public function actionCarExit($gantry_serial)
    {
        /* @var $gantry \common\models\SensorGantry */
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $gantry = SensorGantry::findOne(['serial' => $gantry_serial]);
            if (!$gantry) {
                throw new NotFoundHttpException("Failed to find gantry with serial = $gantry_serial");
            } else {
                SensorGantry::getDb()->transaction(function ($db) use ($gantry) {
                    $gantry->exit_count++;
                    if (!$gantry->save())
                        throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                });
            }

            $car_park = $gantry->carPark;
            CarPark::getDb()->transaction(function ($db) use ($car_park) {
                $car_park->car_count--;
                if (!$car_park->save())
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            });

            $traffic = new TrafficFlow();
            $traffic->sensor_gantry_id = $gantry->id;
            $traffic->entry_count = $gantry->entry_count;
            $traffic->exit_count = $gantry->exit_count;
            $traffic->direction = TrafficFlow::CAR_EXIT;
            $traffic->car_park_id = $car_park->id;
            $traffic->car_count = $car_park->car_count;
            $traffic->empty_lot = max(0, $car_park->lot_capacity - $car_park->car_count);
            if ($traffic->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
            } elseif (!$traffic->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            $transaction->commit();
            return $traffic;

        } catch (Exception $e) {
            $transaction->rollBack();
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }

    public function actionDeleteHoursOlder($hours = 0)
    {
        $deadline = date("Y-m-d H:i:s", strtotime('-' . $hours . ' hours'));
        $records = TrafficFlow::find()->where('updated_at < :updated_at', [':updated_at' => $deadline])->all();
        $count = 0;
        foreach ($records as $record) {
            // Use AR delete so that it wil delete the related file too
            if ($record->delete())
                $count = $count + 1;
        }
        return ['found' => sizeof($records), 'deleted' => $count];
    }

    public function actionLatestByCarPark($car_park_id)
    {
        $sql = "SELECT n1.*
            FROM traffic_flow AS n1
            LEFT JOIN traffic_flow AS n2
              ON (n1.car_park_id = n2.car_park_id AND n1.id < n2.id)
            WHERE n2.car_park_id IS NULL AND n1.car_park_id = :car_park_id";

        $entity = TrafficFlow::findBySql($sql, ['car_park_id' => $car_park_id])->one();

        return $entity;
    }

    public function actionLatestAllCarPark()
    {
        $sql = "SELECT n1.*
            FROM car_park AS cp
            LEFT JOIN traffic_flow AS n1
		ON (cp.id = n1.`car_park_id`)
            LEFT JOIN traffic_flow AS n2
              ON (n1.car_park_id = n2.car_park_id AND n1.id < n2.id)
            WHERE n2.car_park_id IS NULL AND  n1.car_park_id is NOT NULL";

        $entities = TrafficFlow::findBySql($sql)->all();
        return $entities;
    }

    public function actionLatestAllCarParkToday()
    {
        $sql = "SELECT n1.*
            FROM car_park AS cp
            LEFT JOIN traffic_flow AS n1
		ON (cp.id = n1.`car_park_id`)
            LEFT JOIN traffic_flow AS n2
              ON (n1.car_park_id = n2.car_park_id AND n1.id < n2.id)
            WHERE n2.car_park_id IS NULL AND n1.created_at > CURRENT_DATE()";

        $entities = TrafficFlow::findBySql($sql)->all();
        return $entities;
    }

    public function actionListOlderThanHours($hours)
    {
        $sql = "SELECT n1.*
            FROM car_park AS cp
            LEFT JOIN traffic_flow AS n1
		ON (cp.id = n1.`car_park_id`)
            WHERE n1.created_at < (NOW() - INTERVAL :hours HOUR)";

        $entities = TrafficFlow::findBySql($sql, ['hours' => $hours])->all();
        return $entities;
    }

    public function actionClearDaysOlder($days)
    {
        $deadline = date("Y-m-d H:i:s", strtotime('-' . $days . ' days'));
        $count = TrafficFlow::deleteAll('created_at < :created_at', [':created_at' => $deadline]);
        return \yii\helpers\Json::encode(['action' => 'clear-days-older', 'deleted' => $count]);
    }

}