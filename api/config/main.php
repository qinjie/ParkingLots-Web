<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'demo' => [
            'basePath' => '@app/modules/demo',
            'class' => 'api\modules\demo\Module'   // v0 module is for TESTING only
        ],
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'   // v1 module
        ],
    ],
    'components' => [
//        'authManager' => [
//            'class' => 'common\components\PhpManager',
//            'defaultRoles' => ['user', 'manager', 'admin'],
//            # if need to configure following files outside default folder (rbac)
////            'itemFile' => 'app\api\data\items.php', //Default path to items.php
////            'assignmentFile' => 'app\api\data\assignments.php', //Default path to assignments.php
////            'ruleFile' => 'app\api\data\rules.php', //Default path to rules.php
//        ],
        'request' => [
            // Enable JSON Input
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'MXtBcX_ZOCJVA4g9MOz6JoHtUvNFgkv8',
        ],
        'response' => [
            'format' => 'json',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
            'traceLevel' => 3,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@app/runtime/logs/api-error.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@app/runtime/logs/api-warning.log'
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            // Add URL Rules for API
            'rules' => [
//                # For Testing Purpose
//                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
//                    'controller' => 'demo/test-country',
//                    'tokens' => ['{id}' => '<id:\\w+>'],
//                    'extraPatterns' => [
//                        // Simple custom API action
//                        'GET public-hello' => 'public-hello',
//                        'GET search' => 'search',
//                    ],
//                    'except' => [],
//                ],
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'demo/test-person',
//                    'pluralize' => false,
//                    'extraPatterns' => [
//                        // Custom API action with authentication, and uses token from URL
//                        'GET private-hello/{who}' => 'private-hello',
//                        // Custom API with authentication and POST data
//                        'POST secret-hello' => 'secret-hello',
//                        'GET search' => 'search',
//                    ],
//                    'tokens' => ['{who}' => '<who:\\w+>'],
//                ],
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'demo/test-post',
//                    'pluralize' => false,
//                    'extraPatterns' => [ ],
//                ],
                # API for Account
                'GET <version:\w+>/account/login' => '<version>/account/login',
                'GET <version:\w+>/account/logout-all-sessions' => '<version>/account/logout-all-sessions',
                'GET <version:\w+>/account/logout-current-session' => '<version>/account/logout-current-session',
                # API for ActiveRecords
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/car-park',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/sensor-gantry',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/traffic-flow',
                    'extraPatterns' => [
                        'GET search' => 'search',
                        'POST car-entry/{gantry_serial}' => 'car-entry',
                        'POST car-exit/{gantry_serial}' => 'car-exit',
                        'GET latest-by-car-park/{car_park_id}' => 'latest-by-car-park',
                        'GET latest-all-car-park' => 'latest-all-car-park',
                        'GET latest-all-car-park-today' => 'latest-all-car-park-today',
                        'GET list-older-than-hours/{hours}' => 'list-older-than-hours',
                        'DELETE clear-days-older/{days}' => 'clear-days-older',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                        '{hours}' => '<hours:\\d+>',
                        '{gantry_serial}' => '<gantry_serial:\\w+>',
                        '{car_park_id}' => '<car_park_id:\\d+>',
                        '{hours}' => '<hours:\\d+>',
                        '{days}' => '<days:\\d+>',
                    ],
                ],
            ],
        ]
    ],
    'params' => $params,
];