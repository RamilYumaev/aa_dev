<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones\forms\search\CompetitiveListSearch*/

$this->title = 'Конкурсные списки';
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competitive-list/index']];
$this->params['breadcrumbs'][] = $this->title;

use modules\entrant\helpers\SelectDataHelper;
use yii\grid\GridView; ?>
<div>
    <div class="box">
        <div class="box-header">
            <?= \yii\helpers\Html::a('Добавить',['create'], ['class'=> 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\ActionColumn::class, 'template' => '{view} {update}'],
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'cg_id',
                        'label'=> 'КГ',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\entrant\modules\ones\model\CompetitiveGroupOnes::allCgName() , 'cg_id', 'cg_id'),
                        'value' =>'competitiveGroup.name',
                    ],
                    'fio',
                    'snils_or_id',
                    'priority',
                    ['value' => 'subjectMarks', 'header' => 'Баллы за ВИ'],
                    'mark_ai',
                    'sum_ball',
                    ['value' => 'statusName',
                        'filter' => \modules\entrant\modules\ones\model\CompetitiveList::listStatuses(),
                        'attribute' => 'status'
                    ],
//                    ['label' => "#",
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return Html::a('Ведомость', ['study-plan-discipline-student-mark/view',
//                                'study_plan' => $model->study_plan, 'discipline' => $model->discipline, 'semester' => $model->semester]);
//                        }],
//                     ['label' => "",
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return Html::a('Просмотр', ['study-plan/view', 'id' => $model->study_plan, 'discipline' => $model->discipline, 'semester' ], ['target' => '_blank']);
//                        }]
                ],
            ]) ?>
        </div>
    </div>
</div>
