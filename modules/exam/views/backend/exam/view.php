<?php

use modules\exam\forms\ExamQuestionInTestTableMarkForm;

/* @var $this yii\web\View */
/* @var $exam modules\exam\models\Exam */

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = "Экзамен. ".$exam->discipline->name;
$this->params['breadcrumbs'][] = ['label' => 'Экзамен/Аттестация', 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = $this->title;

ModalAsset::register($this);
 ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box box-header">
                <?= Html::a("Редактировать", ['update','id' => $exam->id], ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $exam,
                    'attributes' => [
                        'time_exam',
                        'date_start:date',
                        'date_end:date',
                        'time_start',
                        'time_end',
                        'date_start_reserve:date',
                        'date_end_reserve:date',
                        'time_start_reserve',
                        'time_end_reserve',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= \modules\exam\widgets\exam\TestWidget::widget(['exam_id' => $exam->id]) ?>
    </div>
</div>

