<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'name' => "АИС Абитуриент",
    'aliases' => [
        '@frontendRoot' => $params['staticPath'],
        '@frontendInfo' => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'container' => [
        'definitions' => [
            \backend\widgets\adminlte\grid\GridView::class => \yii\grid\GridView::class,
            \yii\widgets\DetailView::class => [
                'class' => \yii\widgets\DetailView::class,
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '[нет данных]'],
            ],
        ]
    ],
    'modules' => [
        'dictionary-module' => [
            'class' => \modules\dictionary\Dictionary::class
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => \mihaildev\elfinder\Controller::class,
            'access' => ['@', '?'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => '@frontend',
                    'basePath' => '@frontendRoot',
                    'path' => '/',
                    'name' => 'Global',
                    'options' => [
                        'uploadDeny' => ['all'], // All Mimetypes не разрешено загружать
                        'uploadAllow' => ['image', 'text / plain', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'], // Mimetype `image` и` text / plain` разрешено загружать
                        'uploadOrder' => ['deny', 'allow'], // разрешен только Mimetype `image` и` text / plain`
                    ],
                ],
            ],
        ],
        'moderation' => \common\moderation\controllers\ModerationController::class,
        'trail' => \testing\trail\controllers\TestController::class,
        'trail-attempt' => \testing\trail\controllers\TestAttemptController::class
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\auth\Identity',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 60 * 60 * 24, //100 дней для примера
            'loginUrl' => ['auth/auth/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['auth/auth/login', 'site/error', 'auth/auth/logout'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['dev']
            ]
        ]],

    'params' => $params,
];
