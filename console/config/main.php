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
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate-entrant' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['modules\entrant\migrations', 'modules\support\migrations',
                'modules\exam\migrations', 'modules\management\migrations',  'yii\queue\db\migrations',],
        ],
        'migrate-dictionary' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['modules\dictionary\migrations'],
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