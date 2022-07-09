<?php

use yii\grid\ActionColumn;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel modules\exam\searches\ExamSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */

$this->title = "Экзамены";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => ActionColumn::class, 'controller' => 'exam', 'template' => ' {view}'],
                    ['class' => \yii\grid\SerialColumn::class],
                    [
                        'header' => 'Кол-во тестов',
                        'value'=> function (\modules\exam\models\Exam $model) {
                        return $model->getExamTest()->count(); }
                            ],
                    [
                        'header' => 'Автор',
                        'value'=> function (\modules\exam\models\Exam $model) {
                            return $model->profile->fio; }
                    ],
                    ['header' => 'Кол-во запущ. тестов',
                        'value'=> function (\modules\exam\models\Exam $model) {
                        return $model->getExamTest()->andWhere(['status'=> true])->count(); }
                        ],
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
                    ['class' => ActionColumn::class, 'controller' => 'exam', 'template' => ' {view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

