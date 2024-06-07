<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\models\PassExam;
use modules\transfer\widgets\file\FileListWidget;
use modules\transfer\widgets\file\FileWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\transfer\models\StatementTransfer */
/* @var $transferMpgu \modules\transfer\models\TransferMpgu */
/* @var $job \modules\dictionary\models\JobEntrant */?>
<?php
$list = (new PassExam)->listType();
Box::begin(
        [
            "header" => "Аттестация",
            "type" => Box::TYPE_PRIMARY,
            "icon" => 'passport',
            "filled" => true,]) ?>
<?php if (!$model->passExam) :?>
    <?= Html::a("Отклонить", ["pass-exam/danger",  'id' => $model->id], ["class" => "btn btn-danger",
    'data-pjax' => 'w554', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отказа']).
    Html::a('Допустить', ['pass-exam/success', 'id' => $model->id],
    ['class' => 'btn btn-success','data' =>["confirm" => "Вы уверены, что хотите допустить к аттестации?"]]) ?>
<?php else: ?>
<?php if ($job->isAgreement()) :?>
   <?= !$model->is_protocol ? Html::a('Внести в протокол', ['statement/protocol', 'id' => $model->id],
        ['class' => 'btn btn-success','data' =>["confirm" => "Вы уверены, что хотите  сделать это?"]]) : ""?>
    <?= !$model->passExam->isPassYes() ? Html::a('Допустить', ['pass-exam/fix', 'id' => $model->passExam->id],
            ['class' => 'btn btn-success','data' =>["confirm" => "Вы уверены, что хотите допустить к аттестации?"]]) : ""?>
<?php endif; ?>
  <h4><?= '<span class="label label-' .($model->passExam->isPassYes() ? 'success' : 'danger').'">'.($model->passExam->isPassYes() ? 'Допущен' : 'Не допущен').'</span>'; ?></h4>
   <p> <?= $model->passExam->isPassNo() ? $model->passExam->message : ""?></p>
   <?php if ($model->passExam->isPassYes()) :?>
    <p> Статус: <?= $list[$model->passExam->success_exam] ?> <br/>
        <?=
        !$model->passExam->success_exam? Html::a($list[PassExam::SUCCESS],
        ['pass-exam/exam-status', 'id' => $model->passExam->id, 'status'=> PassExam::SUCCESS],
        ['data'=>['confirm'=> 'Вы уверены, что хотите это сделать?'], 'class'=> 'btn btn-success']).
        Html::a($list[PassExam::DONE],
        ['pass-exam/exam-status', 'id' =>$model->passExam->id, 'status'=> PassExam::DONE],
        ['data'=> ['confirm'=> 'Вы уверены, что хотите это сделать?'],  'class'=> 'btn btn-danger']) :
        Html::a($list[PassExam::NO_DATA],
        ['pass-exam/exam-status', 'id' => $model->passExam->id, 'status'=> PassExam::NO_DATA],
        ['data'=> ['confirm'=> 'Вы уверены, что хотите это сделать?'],  'class'=> 'btn btn-warning']);
       ?>
    </p>
    <?php endif; ?>
    <?php if(!$model->passExam->passExamStatement): ?>
    <?= Html::a('Открыть доступ к загрузке файла "Зааявление"', ['pass-exam/statement', 'id' => $model->passExam->id],
    ['class' => 'btn btn-warning','data' =>["confirm" => "Вы уверены, что хотите это сделать?"]]) ?>
    <?php else: ?>
    <?php Box::begin(
    ["header" => "Заявление",
    "type" => Box::TYPE_WARNING,
    "icon" => 'list',
    "filled" => true,]) ?>
    <?= FileWidget::widget(['record_id' => $model->passExam->passExamStatement->id, 'model' => \modules\transfer\models\PassExamStatement::class ]) ?>
    <?= $model->passExam->passExamStatement->countFiles() ? Html::a('Отправить', ['file/send', 'userId' => $model->user_id],
        ['class' => 'btn btn-warning','data' =>["confirm" => "Вы уверены, что хотите отправить файлы?"]]) : '' ?>
    <?= FileListWidget::widget(['record_id' => $model->passExam->passExamStatement->id, 'model' => \modules\transfer\models\PassExamStatement::class, 'userId' => $model->user_id ]) ?>
        <?php Box::end() ?>
    <?php endif; ?>

    <?php if(!$model->passExam->passExamProtocol): ?>
        <?= Html::a('Открыть доступ к загрузке файла "Протокол"', ['pass-exam/protocol', 'id' => $model->passExam->id],
        ['class' => 'btn btn-warning','data' =>["confirm" => "Вы уверены, что хотите это сделать?"]]) ?>
    <?php else: ?>
    <?php Box::begin(
        ["header" => "Протокол",
            "type" => Box::TYPE_INFO,
            "icon" => 'book',
            "filled" => true,]) ?>
    <?= FileWidget::widget(['record_id' => $model->passExam->passExamProtocol->id, 'model' => \modules\transfer\models\PassExamProtocol::class ]) ?>
    <?= $model->passExam->passExamProtocol->countFiles() ? Html::a('Отправить', ['file/send', 'userId' => $model->user_id],
        ['class' => 'btn btn-warning','data' =>["confirm" => "Вы уверены, что хотите отправить файлы?"]]) : '' ?>
    <?= FileListWidget::widget(['record_id' => $model->passExam->passExamProtocol->id, 'model' => \modules\transfer\models\PassExamProtocol::class, 'userId' => $model->user_id ]) ?>
    <?php Box::end() ?>
    <?php endif; ?>
<?php endif; ?>
<?php Box::end() ?>

