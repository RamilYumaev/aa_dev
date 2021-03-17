<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $task modules\management\models\Task */
/* @var $text string */

use modules\management\models\PostRateDepartment;
use yii\helpers\Url;

$url =  Url::to('@entrantInfo/management-user/task/view?id='.$task->id,  true); ?>
<?= $task->responsibleProfile->withBestRegard()?>, <?= $task->responsibleProfile->firstNameAndPatronymic() ?>!

    <?= $text ?>
    Постановщик задачи: <?= implode(', ', PostRateDepartment::find()->getColumnUser($task->director_user_id)) ?> <?= \olympic\helpers\auth\ProfileHelper::profileShortName($task->director_user_id)  ?> 
    Приоритет задачи: <?= $task->position ?>
    Описание задачи: <?= $task->text ?>
    Крайний срок выполнения задачи: <?= $task->dateEndString  ?>
    Подробнее с заданием можете ознакомиться в личном кабинете или по ссылке:<?= $url ?>
    Письмо сгенерировано автоматически и отвечать на него не нужно.
