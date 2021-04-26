<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Личный кабинет поступающего в МПГУ',
    'basePath' => dirname(__DIR__),
    'aliases' => [
       '@frontendRoot' => $params['staticPath'],
        '@frontendInfo' => $params['staticHostInfo'],
    ],
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'container' => [
        'definitions' => [
           \frontend\components\redirect\components\interfaces\IRedirectNewUrl::class => function () {
                return new \frontend\components\redirect\components\RedirectDataFileCsv(
                    Yii::getAlias('@frontend/components/redirect/file/redirect.csv')); }
        ],
    ],
    'modules' => [
        'abiturient' => [
            'class' => \modules\entrant\FrontendEntrant::class,
            'viewPath' => "@modules/entrant/views/frontend",
        ],
        'exam' => [
            'class' => \modules\exam\FrontendExam::class,
            'viewPath' => "@modules/exam/views/frontend",
        ],
        'kladr' => [
            'class' => \modules\kladr\Kladr::class
        ],
        'support' => [
            'class' => \modules\support\ModuleFrontend::class,
            'viewPath' => "@modules/support/views/frontend",
            'yii2basictemplate' => false,
            'adminMatchCallback' => false,//false - for frontend, true - for backend
            'hashGenerator' => null,//user function for generation unique id for ticket or null for standart generator (The ticket id will be something like this: lkLHOoIho)
        ],

    ],
    'controllerMap' => [
        'account' => [
            'class' => \common\auth\controllers\AuthController::class,
            'role' => \olympic\helpers\auth\ProfileHelper::ROLE_STUDENT,
        ],
        'sign-up' => [
            'class' => \common\auth\controllers\SignupController::class,
            'role' => \olympic\helpers\auth\ProfileHelper::ROLE_STUDENT,
        ],
        'schools' => [
            'class' => \common\user\controllers\SchoolsController::class,
            'role' => \olympic\helpers\auth\ProfileHelper::ROLE_STUDENT,
        ],
        'profile' => [
            'class' => \common\auth\controllers\ProfileController::class,
            'view' => 'profile-user',
        ],
        'reset' => \common\auth\controllers\ResetController::class,
        'declination' => \common\user\controllers\DeclinationController::class,

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\auth\Identity',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'authTimeout' => 60 * 60 * 24, //100 дней для примера
            'loginUrl' => ['account/login'],
        ],
        'authClientCollection' => require __DIR__ . '/../../common/config/social.php',
//        'session' => [
//            // this is the name of the session cookie used for login on the frontend
//            'name' => 'advanced-frontend',
//            'savePath'=> '@frontend/runtime/cache',
//            'cookieParams' => ['httponly' => true, 'lifetime' => 86400],
//            'timeout' => 86400, //session expire
//            'useCookies' => true,
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:403',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:401',
                    ],
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
              //  "abiturient/document/update/<id:[\w\-]+>" => "abiturient/document-education/update",
                "index" => "/",
                "site" => "",
                'auth/' => '/',
            ],
        ],
    ],

    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['olympiads/*', 'dod/*', 'print/*', 'gratitude/*',
            'diploma/*','site/*', 'invitation/*', 'schools/*', 'account/*', 'sign-up/*', 'reset/*', 'auth/confirm/*'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@']
            ]
        ]],
    'params' => $params,
];