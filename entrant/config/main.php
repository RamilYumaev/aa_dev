<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-entrant',
    'basePath' => dirname(__DIR__),
    'name' => "АИС \"Абитуриент\"",
    'aliases' => [
        '@frontendRoot' => $params['staticPath'],
        '@frontendInfo' => $params['staticHostInfo'],
        '@entrantRoot' => $params['entrantPath'],
        '@entrantInfo' => $params['entrantHostInfo'],
    ],
    'controllerNamespace' => 'entrant\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'data-entrant' => [
            'class' => \modules\entrant\BackendEntrant::class,
            'viewPath' => "@modules/entrant/views/backend",
        ],
        'management-user' => [
            'class' => \modules\management\Management::class,
            'viewPath' => "@modules/management/views/user",
        ],
        'data-exam' => [
            'class' => \modules\exam\BackendExam::class,
            'viewPath' => "@modules/exam/views/backend",
        ],
        'kladr' => [
            'class' => \modules\kladr\Kladr::class
        ],
        'support' => [
            'class' => \modules\support\ModuleBackend::class,
            'viewPath' => "@modules/support/views/backend",
            'appBackendId' => 'app-entrant',
            'yii2basictemplate' => false,
            'adminMatchCallback' => true,//false - for frontend, true - for backend
            'hashGenerator' => null,//user function for generation unique id for ticket or null for standart generator (The ticket id will be something like this: lkLHOoIho)
        ],
        'dictionary-module' => [
            'class'=> \modules\dictionary\Dictionary::class,
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => \mihaildev\elfinder\Controller::class,
            'access' => ['@', '?'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#...
            'roots' => [
                [
                    'baseUrl' => '@frontendInfo',
                    'basePath' => '@frontendRoot',
                    'path' => '/',
                    'name' => 'Global',
                    'options' => [
                        'uploadDeny' => ['all'], // All Mimetypes не разрешено загружать
                        'uploadAllow' => ['image', 'text / plain', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'], // Mimetype `image` и` text / plain` разрешено загружать
                        'uploadOrder' => ['deny', 'allow'], // разрешен только Mimetype `image` и` text / plain`
                    ],
                ],
                [
                    'baseUrl' => '@entrant',
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
        'account' => [
            'class' => 'common\auth\controllers\AuthController',
            'role' => \olympic\helpers\auth\ProfileHelper::ROLE_ENTRANT,
        ],
        'sign-up' => [
            'class' => \common\auth\controllers\SignupController::class,
            'role' => \olympic\helpers\auth\ProfileHelper::ROLE_ENTRANT,
        ],
        'schools' => [
            'class' => \common\user\controllers\SchoolsController::class,
            'role' => \olympic\helpers\auth\ProfileHelper::ROLE_ENTRANT,
        ],
        'profile' => [
            'class' => \common\auth\controllers\ProfileController::class,
            'view' => 'profile-default',
        ],
        'reset' => \common\auth\controllers\ResetController::class,
        'declination' => \common\user\controllers\DeclinationController::class,
        'moderation' => \common\moderation\controllers\ModerationController::class
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-entrant',
            //'baseUrl'=> '/entrant',
        ],
        'user' => [
            'identityClass' => 'common\auth\Identity',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-entrant', 'httpOnly' => true],
            'authTimeout' => 60 * 60 * 24, //100 дней для примера
            'loginUrl' => ['account/login'],
        ],
        'authClientCollection' => require __DIR__ . '/../../common/config/social.php',
        'session' => [
            // this is the name of the session cookie used for login on the entrant
            'name' => 'advanced-entrant',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
//                'except' => [
//                    'yii\web\HttpException:403',
//                    'yii\web\HttpException:404',
//                    'yii\web\HttpException:400',
//                    'yii\web\HttpException:401',
//                ],
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
        'except' => ['account/*', 'site/error', 'sign-up/*', 'reset/*'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['entrant']
            ]
        ]],

    'params' => $params,
];