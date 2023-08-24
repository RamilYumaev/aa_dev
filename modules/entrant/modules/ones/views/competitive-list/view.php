<?php

use modules\entrant\helpers\SelectDataHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\entrant\modules\ones\model\CompetitiveList */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\entrant\modules\ones\forms\search\CompetitiveListSearch */

$this->title = "Просмотр. " .$model->fio." ".$model->snils_or_id;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсная группа '.$model->competitiveGroup->name, 'url' => ['default/view','id'=> $model->cg_id]];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competitive-list/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <h3>Конкурсные списки Абитуриента</h3>
        </div>
        <div class="box-body">
            <?=  GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['class' => \yii\grid\ActionColumn::class, 'template' => ''],
                    [
                        'attribute' => 'cg_id',
                        'label'=> 'КГ',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\entrant\modules\ones\model\CompetitiveGroupOnes::allCgName(), 'cg_id', 'cg_id'),
                        'value' => function($model) {
                                 return $model->competitiveGroup->name. "(".$model->competitiveGroup->minimal.")";
                        },
                    ],

                     'fio',
                     'number',
                     'snils_or_id',
                     'priority',
                     ['value' => 'subjectMarks', 'header' => 'Баллы за ВИ'],
                     'mark_ai',
                     'sum_ball',
                     ['value' => 'statusName',
                         'filter' => \modules\entrant\modules\ones\model\CompetitiveList::listStatuses(),
                          'attribute' => 'status'
                         ],
                    ['label' => "#",
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a('Просмотр', ['competitive-list/view',
                                'id' => $model->id,]);
                        }],
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
