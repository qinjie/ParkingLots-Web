<?php
namespace api\modules\demo\controllers;

use api\common\controllers\CustomActiveController;
use api\modules\demo\models\TestPost;
use common\components\AccessRule;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class TestPostController extends CustomActiveController
{
    public $modelClass = 'api\modules\demo\models\TestPost';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view',];

        $behaviors['access']['rules'] = [
            [   # No authentication required
                'actions' => ['view'],
                'allow' => true,
                'roles' => ['?', '@'],
            ],
//            [   # Only login user is allowed
//                'actions' => ['index'],
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

}