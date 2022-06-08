<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use dictionary\helpers\DictCompetitiveGroupHelper;
/* @var $this yii\web\View */
/* @var $statementIa modules\entrant\models\StatementIndividualAchievements*/
/* @var $stIa modules\entrant\models\StatementIa */
/* @var $isUserSchool bool */
?>
<?php  Box::begin(
    [
        "header" =>"Заявления об учете индивидуальных достижений №". $statementIa->numberStatement,
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
<p><?= Html::a('Скачать заявление', ['statement-individual-achievements/pdf', 'id' =>  $statementIa->id],
    ['class' => 'btn btn-warning'])?>
<?= $statementIa->statusNewJob() &&  $statementIa->isAllFilesAccepted() &&
    !$statementIa->statementIaCountNoDraft &&  $statementIa->statementIaCountAccepted
    ? Html::a('Рассмотрено', ['statement-individual-achievements/status-accepted','id' => $statementIa ->id],[ 'class' => 'btn btn-success',  'data' => ['method' => 'post', 'confirm' => ' Вы уверены, что хотите поменять статус?']]) : ""; ?>
    <?=  $statementIa->statusNewJob() ? Html::a("Отклонить", ["statement-individual-achievements/message",  'id' => $statementIa->id], ["class" => "btn btn-danger",
        'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения заявления']) :"" ?>
    <?= $statementIa->isStatusNoAccepted() ? Html::a('Возврат', ['statement-individual-achievements/status-index', 'id' => $statementIa->id, 'status'=>StatementHelper::STATUS_WALT],
        ['class' => 'btn btn-success']) : "" ?>

    <span class="label label-<?= StatementHelper::colorName( $statementIa->status)?>">
                        <?= $statementIa->statusNameJob?></span>

</p>
<?= FileListBackendWidget::widget([
    'record_id' => $statementIa->id,  'isCorrect'=> $statementIa->isStatusAccepted(),
    'model' => \modules\entrant\models\StatementIndividualAchievements::class, 'userId' =>$statementIa->user_id ]) ?>

<?php  Box::begin(
    [
        "header" =>"Приложение к заявлению №". $statementIa->numberStatement,
        "type" => Box::TYPE_WARNING,
        "filled" => true,]) ?>
<?php foreach ($statementIa->statementIa as $key => $stIa):  ?>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Наименование</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td><?= ++$key ?>.</td>
        <td><?= $stIa->dictIndividualAchievement->name ?></td>
            <td><?= $stIa->userIndividualAchievements
                && !$stIa->isStatusAccepted()   ?  Html::a('Принять',
                    ['communication/export-statement-ia', 'user' => $statementIa->user_id , 'idIa' => $stIa->id,],
                ['class' => 'btn btn-success', 'data' => ['method' => 'post', 'confirm' => ' Вы уверены, что хотите принять и отправить в АИС ВУЗ ?']]): "" ?></td>
        <td><?= $stIa->isStatusAccepted() ? "" : !$stIa->userIndividualAchievements ?
                Html::a('Удалить',
                    ['statement-individual-achievements/delete-ia', 'id' => $stIa->id,],
                    ['class' => 'btn btn-danger', 'data' => ['method' => 'post', 'confirm' => ' Вы уверены, что хотите удалить?']]): Html::a('Отклонить',  ["statement-individual-achievements/message-ia",  'id' => $stIa->id], ["class" => "btn btn-danger",
                'data-pjax' => 'w2', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения ИД']) ?></td>
        <td> <span class="label label-<?= StatementHelper::colorName( $stIa->status_id)?>">
                        <?= $stIa->statusNameJob ?></span></td>
    </tr>
</table>
    <?php if ($stIa->userIndividualAchievements && $stIa->userIndividualAchievements->dictOtherDocument) : ?>
    <?php  Box::begin(
        [
            "header" =>$stIa->userIndividualAchievements->dictOtherDocument->typeName,
            "type" => Box::TYPE_DANGER,
            "filled" => true,]) ?>
      <p>Данные документа:  <?= $stIa->userIndividualAchievements->dictOtherDocument->otherDocumentBackendFull ?></p>
    <?= FileListBackendWidget::widget(['isCorrect'=> $stIa->isStatusAccepted(), 'record_id' => $stIa->userIndividualAchievements->dictOtherDocument->id, 'model' => \modules\entrant\models\OtherDocument::class, 'userId' =>$statementIa->user_id ]) ?>
<?php Box::end();  endif; endforeach; ?>
<?php Box::end() ?>
