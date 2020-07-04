<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\StatementAgreementContractCg */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Договор"  , "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    );?>

    <?= $model->statusWalt() ? Html::a('Взять в работу', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_VIEW],
    ['class' => 'btn btn-large btn-info', 'data'=>['confirm'=> "Вы уверены, что хотите взять в  работу?"]]) : ""?>
    <?=  Html::a('Проверен', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_ACCEPTED],
    ['class' => 'btn btn-large btn-success', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]])?>
    <?= Html::a('Скачать договор', ['agreement-contract/pdf', 'id' =>  $model->id],
    ['class' => 'btn btn-large btn-warning pull-right'])?>

    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'cg',
                    'number',
                    'fio',
                    'statusName',
                    'created_at:date',
                    'updated_at:date',
                ]
            ]) ?>

    <?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id,
    'model' => $model::className(), 'userId' => $model->statementCg->statement->user_id]) ?>
     <?php if ($model->typeLegal()): ?>
      <?= $this->render('legal', ['model'=> $model->legal]); ?>
     <?php elseif ($model->typePersonal()): ?>
    <?= $this->render('personal', ['model'=> $model->personal]); ?>
     <?php endif; ?>
    <?php Box::end(); endif; ?>
