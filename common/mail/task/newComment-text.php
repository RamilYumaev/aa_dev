<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $commentTask modules\management\models\CommentTask */
/* @var $task modules\management\models\Task */
/* @var $profile \olympic\models\auth\Profiles */
/* @var $text string */

use yii\helpers\Url;
$task = $commentTask->task;
$url =  Url::to('@entrantInfo/management-user/task/view?id='.$task->id,  true); ?>
<?= $profile->withBestRegard()?>, <?= $profile->firstNameAndPatronymic() ?>!

    Новый комментарий к задаче "<?= $task->title  ?>"
    Дата:  <?= $commentTask->dateByString  ?>
    Автор: <?= $commentTask->profile->fio  ?>
    Текст комментарий:  <?= $commentTask->text  ?>
    Подробнее можете ознакомиться в личном кабинете или  по ссылке: <?= $url ?>
    Письмо сгенерировано автоматически и отвечать на него не нужно.
