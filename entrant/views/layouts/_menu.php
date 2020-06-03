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
    }elseif ($jobEntrant && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK()) && in_array($jobEntrant->category_id, JobEntrantHelper::listCategoriesZID())) {
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
                "badge" => "123",
            ],
            [
            "label" => "Принятые ЗУК",
                    "url" => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_RECALL],
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
                    ]]]

        );
    } else {return [];}

}