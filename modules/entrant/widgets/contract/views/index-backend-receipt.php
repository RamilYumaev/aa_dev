<?php

use backend\widgets\adminlte\Box;
use modules\entrant\widgets\file\FileListWidget;
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
    <?= $model->statusWalt() ? Html::a("Принять", ['communication/export-receipt', 'id' =>  $model->id],
    ['class' => 'btn btn-large btn-info', 'data'=>['confirm'=> "Вы уверены, что хотите принять квитанцию?"]]) : ""?>
    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'bank',
                    'pay_sum',
                    'date:date'
                ]
            ]) ?>
    <?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id,
    'model' => $model::className(), 'userId' => $model->contractCg->statementCg->statement->user_id]) ?>

    <?php Box::end(); endif; ?>
