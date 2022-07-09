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
    'language'=> 'ru',
    'aliases' => [
        '@frontendRoot' => $params['staticPath'],
        '@frontendInfo' => $params['staticHostInfo'],
        '@entrantRoot' => $params['entrantPath'],
        '@entrantInfo' => $params['entrantHostInfo'],
    ],
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'container' => [
        'definitions' => [
            \backend\widgets\adminlte\grid\GridView::class => \yii\grid\GridView::class,
            \yii\widgets\DetailView::class => [
                'class' => \yii\widgets\DetailView::class,
            ],
        ]
    ],
    'modules' => [
        'dictionary-module' => [
            'class' => \modules\dictionary\Dictionary::class
        ],
        'management-user' => [
            'class' => \modules\management\Management::class,
            'viewPath' => "@modules/management/views/user",
        ],
        'management-admin' => [
            'class' => \modules\management\AdminManagement::class,
            'viewPath' => "@modules/management/views/admin",
        ],
        'management-director' => [
            'class' => \modules\management\DirectorManagement::class,
            'viewPath' => "@modules/management/views/director",
        ],
        'super-service' => [
            'class' => \modules\superservice\BackendSuperService::class,
            'viewPath' => "@modules/superservice/views/backend",
        ],
        'exam-admin' => [
            'class' => \modules\exam\AdminExam::class,
            'viewPath' => "@modules/exam/views/admin",
        ],
        'support' => [
            'class' => \modules\support\ModuleBackend::class,
            'viewPath' => "@modules/support/views/backend",
            'appBackendId' => 'app-backend',
            'yii2basictemplate' => false,
            'adminMatchCallback' => true,//false - for frontend, true - for backend
            'hashGenerator' => null,//user function for generation unique id for ticket or null for standart generator (The ticket id will be something like this: lkLHOoIho)
        ],
        'data-entrant' => [
            'class' => \modules\entrant\AdminEntrant::class,
            'viewPath' => "@modules/entrant/views/admin",
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => \mihaildev\elfinder\Controller::class,
            'access' => ['@', '?'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => '@frontendInfo',
                    'basePath' => '@frontendRoot',
                    'path' => '/',
                    'name' => 'Global',
                    'options' => [
                        'uploadDeny' => ['all'], // All Mimetypes не разрешено загружать
                        'uploadAllow' => ['image', 'text / plain', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword',  'application/pdf'], // Mimetype `image` и` text / plain` разрешено загружать
                        'uploadOrder' => ['deny', 'allow'], // разрешен только Mimetype `image` и` text / plain`
                    ],
                ],
                [
                    'baseUrl' => '@entrantInfo',
                    'basePath' => '@entrantRoot',
                    'path' => '/work/',
                    'name' => 'UOPP',
                    'options' => [
                        'uploadDeny' => ['all'], // All Mimetypes не разрешено загружать
                        'uploadAllow' => ['image', 'text / plain', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword',  'application/pdf'], // Mimetype `image` и` text / plain` разрешено загружать
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
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_backendUser', // unique for backend
                'path'=>'/admin'  // correct path for the backend app.
            ],
             'loginUrl' => ['auth/auth/login'],
        ],
        'session' => [
            'name' => '_backendSessionId', // unique for backend
            'timeout'=> 60,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
//                'except' => [
  //                  'yii\web\HttpException:403',
    //                'yii\web\HttpException:404',
      //              'yii\web\HttpException:400',
        //            'yii\web\HttpException:401',
          //      ],
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
