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
            ]

        );
    }  elseif($jobEntrant && $jobEntrant->isAgreement()) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']],
                ['label' => 'Договора', 'url' => ['/data-entrant/agreement-contract/index']],
            ]

        );
    }

    elseif ($jobEntrant && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK()) && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZID())) {
        return array_merge(
            [
                ['label' => 'Профиль', 'url' => ['/profile/edit']],
                ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
                ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']],
                ['label' => 'Заявления (ЗУК)', 'url' => ['/data-entrant/statement/index']],
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

            ['label' => 'Экспресс (Новые ЗУК) ', 'url' => ['/data-entrant/statement/new']],
                ['label' => 'Заявления (ЗОС)', 'url' => ['/data-entrant/statement-consent-cg/index']],
            ['label' => 'Экспресс (Новые ЗОС) ', 'url' => ['/data-entrant/statement-consent-cg/new']]]

        );
    } else {return [];}

}