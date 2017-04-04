<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 29/3/15
 * Time: 17:58
 */

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use Yii;
use \yii\base\Exception;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

class SensorGantryController extends CustomActiveController
{
    public $modelClass = 'api\common\models\SensorGantry';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view','index'];

        $behaviors['access']['rules'] = [
            [   // No authentication required
                'actions' => ['view','index'],
                'allow' => true,
                'roles' => ['?', '@'],
            ],
//            [
//                'actions' => ['create'],
//                'allow' => true,
//                'roles' => ['@'],
//            ],
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
//        unset($actions['create']);
        return $actions;
    }

//  ## if need to create customize actions
//    public function actionCreate()
//    {
//        /* @var $model \yii\db\ActiveRecord */
//        $model = new $this->modelClass();
//
//        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
//
//        $module = Yii::$app->controller->module->id;
//        $action = Yii::$app->controller->action->id;
//        $controller = Yii::$app->controller->id;
//        $route = "$module/$controller/$action";
//        if (!Yii::$app->user->can($route, ['model' => $model])) {
//            throw new UnauthorizedHttpException('You are not allowed to access this page.');
//        }
//
//        if ($model->save()) {
//            $response = Yii::$app->getResponse();
//            $response->setStatusCode(201);
//        } elseif (!$model->hasErrors()) {
//            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
//        }
//
//        return $model;
//    }

}
