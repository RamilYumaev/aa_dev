<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictSchools;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictSchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебные организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-index">
    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box table-responsive">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function(DictSchools $model){
                    if (\dictionary\helpers\DictSchoolsReportHelper::isSchoolReport(
                            $model->dict_school_report_id, $model->id)) {
                        return ['class' => 'success'];
                    }
                },
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['attribute' => 'country_id',
                        'filter' => $searchModel->countryList(),
                        'value' => 'country.name'
                    ],
                    ['attribute' => 'region_id',
                        'filter' => $searchModel->regionList(),
                        'value' => 'region.name'
                    ],
                    ['attribute' => 'dict_school_report_id',
                        'format'=> "raw",
                        'filter' => $searchModel->schoolReportList(),
                        'value' => function (DictSchools $model) {
                             if ($model->dict_school_report_id) {
                                 $name = $model->schoolReport->school ? $model->schoolReport->school->name : "";
                                 return Html::a($name, ['dictionary/dict-schools-report/view', 'id' => $model->dict_school_report_id]);
                              }
                             return Html::a("Добавить в чистовик", ['add-in-report', 'id' => $model->id],
                                 ['class'=>'btn btn-success', 'data'=>['method' => 'post', 'confirm' => 'Вы уверены, что хотите 
                                 добавить учебную организацию в чистовик?']]);
                        },
                    ],
                    ['class' => ActionColumn::class,
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>

