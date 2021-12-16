<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\ContractHelper;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\ReceiptContract */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Квитанция"  , "type" => Box::TYPE_INFO,
            "collapsable" => false,
        ]
    );?>
    <?= $model->statusWalt() ? Html::a('Взять в работу', ['receipt-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_VIEW],
    ['class' => 'btn btn-large btn-info', 'data'=>['confirm'=> "Вы уверены, что хотите взять в  работу?"]]) : ""?>
    <?= $model->statusWalt() || $model->statusView()   ? Html::a("Отклонить", ["receipt-contract/message", 'id' => $model->id], ["class" => "btn btn-danger",
    'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения заявления']) :"" ?>
    <?= $model->statusNoAccepted()  ? Html::a('Возврат', ['receipt-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_WALT],
    ['class' => 'btn btn-warning', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : "" ?>

    <?= $model->statusWalt() || $model->statusView()  ? Html::a("Принять", ['receipt-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_ACCEPTED],
    ['class' => 'btn btn-large btn-success', 'data'=>['confirm'=> "Вы уверены, что хотите принять квитанцию?"]]) : ""?>
    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'bank',
                    'pay_sum',
                    'statusName',
                    'date:date'
                ]
            ]) ?>
    <?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id,
    'model' => $model::className(), 'userId' => $model->contractCg->statementTransfer->user_id]) ?>

    <?php Box::end(); endif; ?>
