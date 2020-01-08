<?php
return [
    'language' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'UTC',
        ],
        'olympicMailer' => [
            'class' => 'common\components\Mailer',
            'defaultHost' => 'smtp.gmail.com',
            'defaultUsername' => 'cpk@mpgu.edu',
            'defaultPassword' => 'w5h38c4v1',
            'defaultPort' => '465',
            'defaultEncryption' => 'ssl',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'dirMode' => '777',
            'fileMode' => '777',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
        ],
    ],
];
