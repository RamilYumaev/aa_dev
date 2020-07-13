<?php

/* @var $this yii\web\View */
/* @var $exam modules\exam\models\Exam */

$this->title = "Экзамен. ".$exam->discipline->name;
$this->params['breadcrumbs'][] = ['label' => 'Экзамены', 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\widgets\DetailView; ?>
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
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

