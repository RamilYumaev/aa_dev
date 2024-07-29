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

$columns = [
    ['class' => \yii\grid\ActionColumn::class, 'template' => '{view} {update}'],
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
    'kcp',
    ['attribute'=> 'url',
        'value' => function($model) {
            return $model->url ? 'Да' : 'Нет';
        }],
    'datetime_url',
    ['class' => \yii\grid\ActionColumn::class, 'template' => '{update}'],
];
/** @var \modules\dictionary\models\JobEntrant $role */
$role = Yii::$app->user->identity->jobEntrant();
if(!$role->isCategoryMPGU()) {
    unset($columns[4]);
}
 ?>
<div>
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'afterRow' => function (\modules\entrant\modules\ones_2024\model\CgSS $model, $key, $index, $grid) {
                    return '<tr><td colspan="3">
                                           Абитуриенты СС: '.$model->getEntrantsApp()->count().'<br />
                                             Абитуриенты EPK: '.count($model->getListWithRank()).'<br />
                                           Абитуриенты без позиции: '.count($model->getListNotRank()).'<br />
                                           <td colspan="3">'.
                        ($model->url ?
                            Html::a(
                                'Получить конкурсные списки из epk24.mpgu.su', ['get-list-epk', 'id' => $model->id],
                                ["class" => "btn btn-danger"])
                            . Html::a('Скачать',
                                ['table-file', 'id'=> $model->id],
                                ["class" => "btn btn-success"]
                            ). Html::a('Скачать КС СС',
                                ['table-list', 'id'=> $model->id],
                                ["class" => "btn btn-success"]
                            ) : '').
                        '</td></tr>';
                },
                'columns' => $columns
            ]) ?>
        </div>
    </div>
</div>
