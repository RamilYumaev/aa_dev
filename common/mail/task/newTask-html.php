<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $task modules\management\models\Task */
/* @var $text string */

use modules\management\models\PostRateDepartment;
use yii\helpers\Url;

$url =  Url::to('@entrantInfo/management-user/task/view?id='.$task->id,  true); ?>
<?= $task->responsibleProfile->withBestRegard()?>, <?= $task->responsibleProfile->firstNameAndPatronymic() ?>!
<div>
    <p><?= $text ?></p>
    <p><b>Постановщик задачи:</b> <?= implode(', ', PostRateDepartment::find()->getColumnUser($task->director_user_id)) ?> <?= \olympic\helpers\auth\ProfileHelper::profileShortName($task->director_user_id)  ?> </p>
    <p><b>Приоритет задачи:</b> <?= $task->position ?></p>
    <?php if($task->text): ?>
         <b>Описание задачи:</b> <?= $task->text ?>
    <?php endif; ?>
    <p><b>Крайний срок выполнения задачи:</b> <?= $task->dateEndString  ?></p>
    <p>Подробнее с заданием можете ознакомиться в личном кабинете или <a href="<?= $url ?>">по ссылке.</a></p>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
</div>