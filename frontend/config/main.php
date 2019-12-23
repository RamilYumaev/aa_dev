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
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\auth\Identity',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['auth/auth/login'],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
//                'google' => [
//                    'class' => 'yii\authclient\clients\Google',
//                    'clientId' => 'google_client_id',
//                    'clientSecret' => 'google_client_secret',
//                ],

                'yandex' => [
                    'class' => 'yii\authclient\clients\Yandex',
                    'clientId' => '14ccd7cc6ae04ed680e250aa2b65a369',
                    'clientSecret' => 'f2ed1d137a0443529b607514ad49985f',
                ],

                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '993150624227282',
                    'clientSecret' => '062d3794e0913366d9dd9aef50bfbd4f',
                    'scope' => 'email',
                ],

                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '6840071',
                    'clientSecret' => 'kjKLyc2zgJB5k9pL80A9',
                    'scope' => 'email',
                ]

            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
                "index" => "/",
                "site" => "",
                'auth/' => '/',
            ],
        ],
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['olympiads/*', 'dod/*', 'auth/signup/*', 'auth/reset/*','site/index','auth/auth/login', 'invitation/*',
            'auth/auth/auth', 'schools/*'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@']
            ]
        ]],
    'params' => $params,
];