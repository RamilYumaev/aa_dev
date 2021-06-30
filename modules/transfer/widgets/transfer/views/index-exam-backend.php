<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\transfer\models\StatementTransfer */
/* @var $transferMpgu \modules\transfer\models\TransferMpgu */
?>
<?php Box::begin(
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
  <h4><?= '<span class="label label-' .($model->passExam->isPassYes() ? 'success' : 'danger').'">'.($model->passExam->isPassYes() ? 'Допущен' : 'Недопущен').'</span>'; ?></h4>
   <p> <?= $model->passExam->isPassNo() ? $model->passExam->message : ""?></p>
<?php endif; ?>
<?php Box::end() ?>

