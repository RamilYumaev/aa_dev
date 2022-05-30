<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'container' => [
        'singletons' => [
      \modules\superservice\amqp\Serializer::class => ['class' => \modules\superservice\amqp\Serializer::class],
            \modules\superservice\amqp\Publisher::class => ['class' =>  \modules\superservice\amqp\Publisher::class],
    \modules\superservice\handlers\ResponseHandler::class => ['class' => \modules\superservice\handlers\ResponseHandler::class],
            ]],
    'modules' => [
        'superservice' => [
            'class' => \modules\superservice\SuperService::class]
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['modules\entrant\migrations', 'modules\support\migrations',
                'modules\transfer\migrations',
                'modules\exam\migrations', 'modules\management\migrations',  'yii\queue\db\migrations',
                'modules\student\migrations',
                'modules\literature\migrations',
                'modules\superservice\migrations',
                'modules\dictionary\migrations'],
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];