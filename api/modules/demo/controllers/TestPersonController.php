<?php
namespace api\modules\demo\controllers;

use api\common\controllers\CustomActiveController;
use api\modules\demo\models\TestPerson;
use common\components\AccessRule;
use common\models\User;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class TestPersonController extends CustomActiveController
{
    public $modelClass = 'api\modules\demo\models\TestPerson';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view', 'index', 'search'];
        # We will override the default rule config with the new AccessRule class
        # Reference https://thecodeninja.net/2014/12/simpler-role-based-authorization-in-yii-2-0/
        $behaviors['access']['ruleConfig'] = [
            'class' => AccessRule::className(),
        ];

        $behaviors['access']['rules'] = [
            ['actions' => ['secret-hello'],
                'allow' => true,
                'roles' => [User::ROLE_MANAGER, User::ROLE_ADMIN, User::ROLE_MASTER],
            ],
            ['actions' => ['create', 'delete', 'update', 'private-hello'],
                'allow' => true,
                'roles' => ['@',],
            ],
            [   // No authentication required
                'actions' => ['view', 'index', 'search'],
                'allow' => true,
                'roles' => ['?', '@'],
            ],
        ];

        return $behaviors;
    }


    //-- Custom action, routing is defined in web.php
    public function actionPrivateHello($who)
    {
        return [
            'message' => 'Private Hello ' . $who,
            'siteroot' => \Yii::getAlias('@siteroot'),
            'baseurl' => Url::base(),
            'baseurl_true' => Url::base(true),
            'module' => \Yii::$app->controller->module->id,
        ];
    }

    //-- Custom action, routing is defined in web.php
    public function actionSecretHello()
    {
        //-- Get data in JSON format from POST
        $post_json = json_decode(file_get_contents("php://input"), true);

        //-- Set it to attributes of an Object
        //$nodeFile->attributes = $post_json;

        return [
            'message' => 'Hello Secretly ' . json_encode($post_json),
            'siteroot' => \Yii::getAlias('@siteroot'),
            'baseurl' => Url::base(),
            'baseurl_true' => Url::base(true),
            'module' => \Yii::$app->controller->module->id,
        ];
    }


}