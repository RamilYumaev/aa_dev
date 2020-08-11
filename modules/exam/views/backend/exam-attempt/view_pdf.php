<?php

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $attempt \modules\exam\models\ExamAttempt */


$column = [
        ['attribute' => 'user_id',
            'value' => $attempt->profile->fio,
        ],
        'start:datetime',
        'end:datetime',
        'typeName',
         'mark',
];
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box box-header">
                <?= $attempt->user_id == Yii::$app->user->identity->getId() ? Html::a("Удалить", ['delete',
                    'id' => $attempt->id], ['class' => 'btn btn-danger', 'data' => ['method' => 'post', 'confirm' => "Вы уверены что хотите удалить попытку?"]]) : "" ?>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $attempt,
                    'attributes' => $column,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= modules\exam\widgets\exam\TestResultWidget::widget(['attempt'=>$attempt, 'size'=> 50]) ?>
    </div>
</div>

