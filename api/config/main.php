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
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static'   => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => [
        'log',
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                 'application/json' => \yii\web\Response::FORMAT_JSON,
               // 'application/xml' => 'xml',
            ],
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'fklsjgzkjpeosipoiops',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => \api\providers\User::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
         'urlManager' => [
             'enablePrettyUrl' => true,
             'enableStrictParsing' => true,
             'showScriptName' => false,
             'rules' => [
                 '' => 'site/index',
                 'scan' => 'scan/index',
                 'scan/token' => 'scan/token',
                 'scan/presence' => 'scan/presence',
                 'communication' => 'communication/index',
                 'dictionary' => 'communication/dictionary',
             ],
         ],
    ],


    'params' => $params,
];
