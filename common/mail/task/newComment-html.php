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
<div>
    <p>Новый комментарий к задаче "<?= $task->title  ?>"</p>
    <p>Дата:  <?= $commentTask->dateByString  ?></p>
    <p>Автор: <?= $commentTask->profile->fio  ?></p>
    <p>Текст комментарий:  <?= $commentTask->text  ?></p>
    <p>Подробнее можете ознакомиться в личном кабинете или <a href="<?= $url ?>">по ссылке.</a></p>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
</div>