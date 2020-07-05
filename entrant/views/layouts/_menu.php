<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\StatementHelper;

if(!Yii::$app->user->isGuest ) {
    $jobEntrant = Yii::$app->user->identity->jobEntrant();
    if($jobEntrant && $jobEntrant->isCategoryCOZ()) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']],
               \Yii::$app->user->can('moderation') ? ['label' => 'Модерация', 'url' => ['/moderation']] : [],
               \Yii::$app->user->can('ticket') ? ['label' => 'Вопросы от абитуриентов', 'url' => ['/support']] : [],
               \Yii::$app->user->can('edu_school') ? ['label' => 'Учебные организации', 'url' => '#',
                    'items' => [
                        ['label' => 'Список', 'url' => ['/dictionary-module/dict-schools']],
                        ['label' => 'Для отчета', 'url' => ['/dictionary-module/dict-schools-report']],
                    ]] : [],
            ]

        );
    }  elseif($jobEntrant && $jobEntrant->isAgreement()) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']],
                ['label' => 'Договоры', 'url' => ['/data-entrant/agreement-contract/index']],
                ['label' => 'Квитанции', 'url' => ['/data-entrant/receipt-contract/index']],
            ]

        );
    }

    elseif($jobEntrant && $jobEntrant->isCategoryTarget()) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Абитуриенты ТД', 'url' => ['/data-entrant/default/index', 'is_id' => JobEntrantHelper::TASHKENT_BB]],
                ['label' => 'Абитуриенты ЦиС', 'url' => ['/data-entrant/default/index', 'is_id' => JobEntrantHelper::TARGET_BB]],
                ['label' => 'Целевые договоры', 'url' => ['/data-entrant/agreement/index']],
            ]

        );
    }

    elseif ($jobEntrant && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK()) && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZID())) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Заявления (ЗУК)',
                    "items" => [
                        [
                            "label" => 'Просмотр',
                            "url" => ['/data-entrant/statement/index'],
                            "icon" => "table",
                        ],
                        [
                            "label" => "Принятые ЗУК",
                            "url" => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_ACCEPTED],
                            "icon" => "list",
                        ],
                        [
                            "label" => "Непринятые ЗУК",
                            "url" => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED],
                            "icon" => "list-ul",
                        ],
                        [
                            "label" => "Отозванные ЗУК",
                            "url" => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_RECALL],
                            "icon" => "list-ol",
                        ]
                    ]],

                ['label' => 'Экспресс (Новые ЗУК)', 'url' => ['/data-entrant/statement/new']],
                ['label' => 'Заявления (ЗОС)', 'url' => ['/data-entrant/statement-consent-cg/index']],
                ['label' => 'Экспресс (Новые ЗОС)', 'url' => ['/data-entrant/statement-consent-cg/new']],
                [
                    "label" => "Ход подачи",
                    "url" => '/data-entrant/charts',
                    "icon" => "table",
                ],
                ['label' => 'Абитуриенты (ЗИД)', 'url' => ['/data-entrant/default/index']],
                ['label' => 'Заявления (ЗИД)', 'url' => ['/data-entrant/statement-individual-achievements/index']],
            ]

        );
    }
    elseif ($jobEntrant && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZID())  && !in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK())) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']],
                ['label' => 'Заявления (ЗИД)', 'url' => ['/data-entrant/statement-individual-achievements/index'],
                 ]
            ]

        );
    }elseif ($jobEntrant && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK()) && !in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZID())) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']],


                ['label' => 'Заявления (ЗУК)',
                "items" => [
            [
                "label" => 'Просмотр',
                "url" => ['/data-entrant/statement/index'],
                "icon" => "table",
            ],
            [
            "label" => "Принятые ЗУК",
                    "url" => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_ACCEPTED],
                    "icon" => "list",
                ],
                    [
                        "label" => "Непринятые ЗУК",
                        "url" => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED],
                        "icon" => "list-ul",
                    ],
                    [
                        "label" => "Отозванные ЗУК",
                        "url" => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_RECALL],
                        "icon" => "list-ol",
                    ]
                    ]],

            ['label' => 'Экспресс (Новые ЗУК)', 'url' => ['/data-entrant/statement/new']],
                ['label' => 'Заявления (ЗОС)', 'url' => ['/data-entrant/statement-consent-cg/index']],
            ['label' => 'Экспресс (Новые ЗОС)', 'url' => ['/data-entrant/statement-consent-cg/new']],
                [
                    "label" => "Ход подачи",
                    "url" => '/data-entrant/charts',
                    "icon" => "table",
                ],]

        );
    } else {return [];}

}