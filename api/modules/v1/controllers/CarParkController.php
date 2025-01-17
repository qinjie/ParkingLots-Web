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

class CarParkController extends CustomActiveController
{
    public $modelClass = 'api\common\models\CarPark';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view', 'index'];

        $behaviors['access']['rules'] = [
            [   // No authentication required
                'actions' => ['view', 'index'],
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
}