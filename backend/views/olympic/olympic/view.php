<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\CategoryDocHelper;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\Olympic  */


$this->title = "Просмотр";
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div>
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $olympic->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $olympic->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $olympic,
        'attributes' => [
            'name',
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
