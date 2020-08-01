<?php

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $attempt \modules\exam\models\ExamAttempt */

$this->title = "Просмотр попытки";
$this->params['breadcrumbs'][] = ['label' => "Экзамены", 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = ['label' => "Экзамен. ".
    $attempt->test->exam->discipline->name, 'url' => ['exam/view',
    'id' => $attempt->exam_id]];
$this->params['breadcrumbs'][] = ['label' => $attempt->test->name,
    'url' => ['exam-test/view', 'id' => $attempt->test_id]];
$this->params['breadcrumbs'][] = ['label' => "Попытки ".$attempt->typeName,
    'url' => ['index', 'test_id' => $attempt->test_id, 'type'=> $attempt->type]];

$this->params['breadcrumbs'][] = $this->title;
ModalAsset::register($this);

$column = [
        ['attribute' => 'user_id',
            'value' => $attempt->profile->fio,
        ],
        'start:datetime',
        'end:datetime',
        'typeName',
         'mark',
];
if ($attempt->test->exam->discipline_id !== 22) {
    unset($column[4]);
}
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
        <?= modules\exam\widgets\exam\TestResultWidget::widget(['attempt'=>$attempt]) ?>
    </div>
</div>

