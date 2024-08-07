<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\CgSSSearch */

use dictionary\helpers\DictFacultyHelper;
use modules\entrant\helpers\SelectDataHelper;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Конкурсные группы';
$this->params['breadcrumbs'][] = $this->title;

$fileName = "all-list.xlsx";
$file = \Yii::getAlias('@modules').'/entrant/files/ss/'.$fileName;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= \yii\helpers\Html::a("Получить все списки из epk", ['get-all'], ['class' => 'btn btn-warning']) ?>
            <?= \yii\helpers\Html::a("Сгенерирвать все списки в один файл", ['all-list'], ['class' => 'btn btn-success']) ?>
            <?= file_exists($file) ? \yii\helpers\Html::a("Скачать файл", ['get-all-list'], ['class' => 'btn btn-success']) : ""?>
            <?= \yii\helpers\Html::a("Очистить и подготвить данные для конкурса", ['data-all-competitive'], ['class' => 'btn btn-info']) ?>
            <?= Html::a('Провести конкурс', ['final-handle'], ['class'=>'btn btn-danger', 'data-confirm'=> "Вы уверенны, что хотите это сделать?"]) ?>
        </div>
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function(\modules\entrant\modules\ones_2024\model\CgSS $model){
                    if($model->kcp > 0) {
                        if ($model->getCountStatuses(\modules\entrant\modules\ones_2024\model\CompetitiveList::STATUS_SUCCESS) ==  $model->kcp) {
                            return ['class' => 'success'];
                        }
                        else {
                            return ['class' => 'warning'];
                        }
                    }
                    return ['class' => 'default'];
                },
                'afterRow' =>function (\modules\entrant\modules\ones_2024\model\CgSS $model, $key, $index, $grid) {
                    return '<tr><td colspan="3">
                                           Абитуриенты СС: '.$model->getEntrantsApp()->count().'<br />
                                             Абитуриенты EPK: '.count($model->getListWithRank()).'<br />
                                           Абитуриенты без позиции: '.count($model->getListNotRank()).'<br />
                                           Абитуриенты для конкурса: '.count($model->getListForCompetitive()).'<br />
                                           <td colspan="3">'.
                        ($model->url ?
                            Html::a(
                'Получить конкурсные списки из epk24.mpgu.su', ['get-list-epk', 'id' => $model->id],
                ["class" => "btn btn-danger"])
                            . Html::a('Скачать',
                ['table-file', 'id'=> $model->id],
                ["class" => "btn btn-success"]
            )    . Html::a('Скачать КС СС',
                                ['table-list', 'id'=> $model->id],
                                ["class" => "btn btn-success"]
                                ). Html::a('Скачать файл "Отбор абитуриентов для конкурса"',
                                ['table-file', 'id'=> $model->id, 'competitive' => 1],
                                ["class" => "btn btn-info"]
                            ). Html::a('Скачать файл "Результаты конкурса"',
                                ['table-competitive', 'id'=> $model->id],
                                ["class" => "btn btn-warning"]
                            ) : '').
                        '</td></tr>';
                     },
                'columns' => [
                    ['class' => \yii\grid\ActionColumn::class, 'template' => '{view} {update}'],
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    'education_level',
                    'education_form',
                    ['attribute' => 'faculty_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, DictFacultyHelper::facultyList(),'faculty_id', 'faculty.full_name'),
                        'value' => 'faculty.full_name',
                    ],
                    'code_spec',
                    'speciality',
                    'profile',
                    'type',
                    ['value' => 'statusName',
                        'filter' => $searchModel::listStatuses(),
                        'attribute' => 'status'
                    ],
                    'kcp',
                    ['attribute'=> 'url',
                        'value' => function($model) {
                            return $model->url ? 'Да' : 'Нет';
                        }],
                    'datetime_url',
                      ['class' => \yii\grid\ActionColumn::class, 'template' => '{update}'],
                ]
            ]) ?>
        </div>
    </div>
</div>
