<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\EntrantAppSearch */

use yii\helpers\Html;

$this->title = 'Заявления';
$this->params['breadcrumbs'][] = $this->title;
 ?>
<div>
    <div class="box">
        <div class="box-body table-responsive">
            <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'addButtons' => [],
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['header' => 'ФИО',
                        'attribute' => 'fio',
                        'value' => 'entrant.fio'
                    ],
                    ['header' => 'СНИЛС',
                        'attribute' => 'snils',
                        'value' => 'entrant.snils'
                    ],
                    ['header' => 'КГ',
                        'attribute' => 'cgName',
                        'value' => 'cg.name'
                    ],
                    'actual',
                    'priority_vuz',
                    'priority_ss',
                    'status',
                    'source',
                    'is_el_original:boolean',
                    'is_paper_original:boolean',
                    ['label' => "#",
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a('Просмотр', ['competitive-list/view',
                                'id' => $model->id,]);
                        }],
                ],
                'actionColumnTemplate' => '',
            ]) ?>
        </div>
    </div>
</div>
