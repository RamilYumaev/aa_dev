<?php
return [
    'language' => 'ru_RU',
     'timeZone' => 'Europe/Moscow',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'debug' => [
            'class' => \yii\debug\Module::class,
            'panels' => [
                'queue' => \yii\queue\debug\Panel::class,
            ],
        ],
    ],
    'components' => [
      'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'Europe/Moscow'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'dirMode' => '777',
            'fileMode' => '777',
        ],
        'inflection' => [
            'class' => 'wapmorgan\yii2inflection\Inflection'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
        ],
        'queue'=> ['class' => \yii\queue\sync\Queue::class, 'handle' => true,]
    ],
];
