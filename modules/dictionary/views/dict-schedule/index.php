<?php


use dictionary\helpers\DictRegionHelper;
use kartik\date\DatePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\DictScheduleSearch*/

$this->title = 'Справочник графиков работы волонтеров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute'=> 'date',
                        'value' => 'date',
                        'format' => 'date',
                        'filter' => DatePicker::widget([
                            'language' => 'ru',
                            'model' => $searchModel,
                            'attribute' => 'date',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ],
                        ])
                    ],
                    'count',
                    ['attribute'=> 'category',
                        'value' => 'categoryName',
                        'filter' => \modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories()
                   ],
                    ['class' => ActionColumn::class,
                        'controller' => "dict-schedule",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
