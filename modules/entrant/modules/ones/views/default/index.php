<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones\forms\search\CompetitiveGroupSearch */

$this->title = 'Конкурсные группы';
$this->params['breadcrumbs'][] = $this->title;

use modules\entrant\modules\ones\model\CompetitiveList; ?>
<div>
    <div class="box">
        <div class="box-body table-responsive">
            <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function(\modules\entrant\modules\ones\model\CompetitiveGroupOnes $model){
                if($model->kcp > 0) {
                    if ($model->getCountStatuses(CompetitiveList::STATUS_SUCCESS) ==  $model->kcp) {
                        return ['class' => 'success'];
                    }
                    else {
                        return ['class' => 'warning'];
                    }
                }
                    return ['class' => 'default'];
                },
                'actionColumnTemplate' => '{update}',
                'columns' => [
                    ['class' => \yii\grid\ActionColumn::class, 'template' => '{view}'],
                    ['class' => \yii\grid\SerialColumn::class],
                    'name', 'education_level',
                    'education_form', 'department',
                    'speciality', 'profile',
                    'type_competitive',
                    ['value' => 'statusName',
                        'filter' => \modules\entrant\modules\ones\model\CompetitiveGroupOnes::listStatuses(),
                        'attribute' => 'status'
                    ],
                     'kcp',
                     'kcp_transfer',
                    ['value' => function(\modules\entrant\modules\ones\model\CompetitiveGroupOnes $model) {
                          return $model->getCountStatuses();
                    },
                        'label' => "Кол-во заявлений",
                    ],
                    ['value' => function(\modules\entrant\modules\ones\model\CompetitiveGroupOnes $model) {
                        return $model->getMinimal();
                    },
                        'label' => "Мин. проходной балл",
                    ],
                ]
            ]) ?>
        </div>
    </div>
</div>
