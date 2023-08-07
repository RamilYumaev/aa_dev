<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones\forms\search\OrderTransferSearch*/

$this->title = 'Приказы';
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

use modules\entrant\helpers\SelectDataHelper;
use yii\grid\GridView;
use yii\helpers\Html; ?>
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
                    ['attribute' => 'department',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\entrant\modules\ones\model\OrderTransferOnes::allDepartments() , 'department', 'department'),
                        'value' =>'department',
                    ],
                    ['attribute' => 'education_level',
                        'filter' => \modules\entrant\modules\ones\model\OrderTransferOnes::allEduLevels(),
                        'value' =>'education_level',
                    ],
                    ['attribute' => 'education_form',
                        'filter' => \modules\entrant\modules\ones\model\OrderTransferOnes::allForms(),
                        'value' => 'education_form',
                    ],
                    ['attribute' => 'type_competitive',
                        'filter' => \modules\entrant\modules\ones\model\OrderTransferOnes::allTypes(),
                        'value' =>'type_competitive',
                    ],
                    ['label' => "#",
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a('Приказ', ['order',
                                'id' => $model->id, 'st'=>'p']) ." || ". Html::a('Сведения', ['order',
                                    'id' => $model->id, 'st'=>'s']);
                        }],
                ],
            ]) ?>
        </div>
    </div>
</div>
