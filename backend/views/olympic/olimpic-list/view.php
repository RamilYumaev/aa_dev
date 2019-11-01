<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\CategoryDocHelper;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\OlimpicList  */


$this->title = "Просмотр";
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-default">
    <div class="box box-header">
    <p><?= Html::a('Вернуться', ['olympic/olympic/view', 'id' => $olympic->olimpic_id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Обновить', ['update', 'id' => $olympic->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $olympic->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
        <p>
        </p>
    </p>
    </div>
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $olympic,
        'attributes' => [
            'name',
            'year',
            'chairman_id',
            'number_of_tours',
            'form_of_passage',
            'edu_level_olymp',
            'date_time_start_reg',
            'date_time_finish_reg',
            'time_of_distants_tour',
            'date_time_start_tour',
            'address:ntext',
            'time_of_tour',
            'requiment_to_work_of_distance_tour:ntext',
            'requiment_to_work:ntext',
            'criteria_for_evaluating_dt:ntext',
            'criteria_for_evaluating:ntext',
            'showing_works_and_appeal',
        ],
    ]) ?>
    </div>
</div>
