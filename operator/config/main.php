<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-operator',
    'basePath' => dirname(__DIR__),
    'name' => "ЛК организатора олимпиад и конкурсов",
    'aliases' => [
        '@frontendRoot' => $params['staticPath'],
        '@frontendInfo' => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'operator\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
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
            ],
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-operator',
            //'baseUrl'=> '/manager',
        ],
        'user' => [
            'identityClass' => 'common\auth\Identity',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-operator', 'httpOnly' => true],
            'authTimeout' => 60 * 60 * 24, //100 дней для примера
            'loginUrl' => ['auth/auth/login'],
        ],
        //'authClientCollection' => require __DIR__ . '/../../common/config/social.php',
        'session' => [
            // this is the name of the session cookie used for login on the operator
            'name' => 'advanced-operator',
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
                'roles' => ['olymp_operator']
            ]
        ]],

    'params' => $params,
];