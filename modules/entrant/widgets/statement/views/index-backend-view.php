<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileListWidget;


/* @var $this yii\web\View */
/* @var $statement modules\entrant\models\Statement*/
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<?php  Box::begin(
    [
        "header" =>"Заявление  №". $statement->numberStatement,
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
    <p>Заявление  №<?= $statement->numberStatement ?>
        <?= $statement->faculty->full_name ?>/
        <?= $statement->speciality->codeWithName ?>/
        <?= $statement->eduLevel ?>/
        <?= $statement->specialRight ?>

        <?= Html::a('Скачать заявление', ['statement/pdf', 'id' =>  $statement->id],
    ['class' => 'btn btn-large btn-warning'])?>
        <?= $statement->statusNewJob() && $statement->isAllFilesAccepted() ?
            Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
                ['/data-entrant/communication/export-statement',
                    'user' => $statement->user_id, 'statement' => $statement->id],
                ['data-method' => 'post', 'class' => 'btn btn-success']) : '';  ?>
        <?=  $statement->statusNewJob() ? Html::a("Отклонить", ["statement/message",  'id' => $statement->id], ["class" => "btn btn-danger",
            'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения заявления']) :"" ?>
        <?= $statement->statusNoAccepted() ? Html::a('Возврат', ['statement/status', 'id' => $statement->id, 'status'=>StatementHelper::STATUS_WALT],
            ['class' => 'btn btn-success']) : "" ?>

                 <span class="label label-<?= StatementHelper::colorName($statement->status)?>">
                        <?=$statement->statusNameJob?></span>
    </p>

<table class="table table-bordered">
             <tr>
                 <th>Образовательные программы</th>
             </tr>
             <?php foreach ($statement->statementCg as $statementCg): ?>
             <tr>
                <td><?= $statementCg->cg->fullName ?></td>
             </tr>
             <?php if($statementCg->statementRejection): ?>
             <tr>
                <td>
                    <?php  Box::begin(
                        [
                            "header" =>"Отзыв конкурсной группы",
                            "type" => Box::TYPE_WARNING,
                            "filled" => true,]) ?>
                    <h4></h4>
                    <p>
                        <?= Html::a('Скачать заявление', ['statement-rejection/pdf-cg', 'id' =>  $statementCg->statementRejection->id],
                            ['class' => 'btn btn-large btn-warning'])?>
                        <?= $statementCg->statementRejection->statusNewJob() &&
                        $statementCg->statementRejection->isAllFilesAccepted() ?
                            Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
                                ['/data-entrant/communication/export-statement-remove-cg',
                                   'statementId' =>  $statementCg->statementRejection->id],
                                ['data-method' => 'post', 'class' => 'btn btn-success']) : '';  ?>
                        <?=   $statementCg->statementRejection->statusNewJob() ? Html::a("Отклонить", ["statement-rejection/message-cg",  'id' =>  $statementCg->statementRejection->id], ["class" => "btn btn-danger",
                            'data-pjax' => 'w15', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения отозванного заявления']) :"" ?>
                        <?=  $statementCg->statementRejection->statusNoAccepted() ? Html::a('Возврат', ['statement-rejection/status-cg', 'id' =>  $statementCg->statementRejection->id, 'status'=>StatementHelper::STATUS_WALT],
                            ['class' => 'btn btn-success']) : "" ?>
                        <span class="label label-<?= StatementHelper::colorName( $statementCg->statementRejection->status_id)?>">
                        <?= $statementCg->statementRejection->statusNameJob?></span>
                        <?= FileListBackendWidget::widget([ 'record_id' => $statementCg->statementRejection->id,
                            'isCorrect'=> $statementCg->statementRejection->isStatusAccepted(),
                            'model' => \modules\entrant\models\StatementRejectionCg::class, 'userId' => $statement->user_id ]) ?>
                    </p>
                    <?php Box::end() ?>
                </td>
             </tr>
             <?php  endif; endforeach; ?>
</table>
<?= FileListBackendWidget::widget([ 'record_id' => $statement->id, 'isCorrect'=> $statement->isStatusAccepted(), 'model' => \modules\entrant\models\Statement::class, 'userId' => $statement->user_id ]) ?>

<?php  if ($statement->statementRejection) :?>
    <?php  Box::begin(
        [
            "header" =>"Отозванное заявление  №". $statement->numberStatement,
            "type" => Box::TYPE_DANGER,
            "filled" => true,]) ?>
    <p>
    <?= Html::a('Скачать заявление', ['statement-rejection/pdf', 'id' =>  $statement->statementRejection->id],
        ['class' => 'btn btn-large btn-warning'])?>
    <?= $statement->statementRejection->statusNewJob() && $statement->statementRejection->isAllFilesAccepted() ?
        Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
            ['/data-entrant/communication/export-statement-remove',
               'statementId' => $statement->statementRejection->id],
            ['data-method' => 'post', 'class' => 'btn btn-success']) : '';  ?>
        <?=  $statement->statementRejection->statusNewJob() ? Html::a("Отклонить", ["statement-rejection/message",  'id' => $statement->statementRejection->id], ["class" => "btn btn-danger",
            'data-pjax' => 'w5', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения отозванного заявления']) :"" ?>
        <?= $statement->statementRejection->statusNoAccepted() ? Html::a('Возврат', ['statement-rejection/status', 'id' => $statement->statementRejection->id, 'status'=>StatementHelper::STATUS_WALT],
            ['class' => 'btn btn-success']) : "" ?>


        <span class="label label-<?= StatementHelper::colorName($statement->statementRejection->status_id)?>">
                        <?= $statement->statementRejection->statusNameJob?></span>
    </p>

    <?= FileListBackendWidget::widget([ 'record_id' => $statement->statementRejection->id, 'isCorrect'=> $statement->statementRejection->isStatusAccepted(), 'model' => \modules\entrant\models\StatementRejection::class, 'userId' => $statement->user_id ]) ?>
    <?php Box::end() ?>

<?php  endif;?>

<?php Box::end() ?>
