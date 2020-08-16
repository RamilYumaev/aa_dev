<?php

use modules\exam\models\Exam;
use yii\grid\ActionColumn;
use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel modules\exam\searches\ExamSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */

$this->title = "Экзамены";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['exam/create'], ['class' => 'btn btn-success mb-10']) ?>
        </div>
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'discipline_id',
                        'filter'=> $searchModel->filterDiscipline(),
                        'value'=> 'discipline.name'],
                    'time_exam',
                    'date_start:date',
                    'date_end:date',
                    'time_start',
                    'time_end',
                    'date_start_reserve:date',
                    'date_end_reserve:date',
                    'time_start_reserve',
                    'time_end_reserve',
                    ['class' => ActionColumn::class, 'controller' => 'exam', 'template' => '{update} {view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

