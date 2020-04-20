<?php

use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $attempt testing\models\TestAttempt */

$this->title = "Просмотр попытки";
$this->params['breadcrumbs'][] = ['label' => "Tecт",
    'url' => ['/testing/test/view', 'id' => $attempt->test_id]];
$this->params['breadcrumbs'][] = ['label' => "Попытки",
    'url' => ['index', 'test_id' => $attempt->test_id]];
//$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicListHelper::olympicAndYearName($test->olimpic_id),
//    'url' => ['/olympic/olimpic-list/view', 'id' => $test->olimpic_id]];

$this->params['breadcrumbs'][] = $this->title;
\backend\assets\modal\ModalAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box box-header">
                <?= $attempt->user_id == Yii::$app->user->identity->getId() ? \yii\helpers\Html::a("Удалить", ['delete', 
                    'id' => $attempt->id], ['class' => 'btn btn-danger', 'data' => ['method' => 'post', 'confirm' => "Вы уверены что хотите удалить попытку?"]]) : "" ?>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $attempt,
                    'attributes' => [
                        //'name'
                        ['attribute' => 'user_id',
                            'value' => \olympic\helpers\auth\ProfileHelper::profileFullName($attempt->user_id),
                            ],
                        'start:datetime',
                        'end:datetime',
                        'mark',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= \backend\widgets\testing\TestResultWidget::widget(['attempt_id'=>$attempt->id]) ?>
    </div>
</div>

