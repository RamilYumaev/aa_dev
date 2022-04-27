<?php

use modules\dictionary\models\TestingEntrant;
use modules\entrant\helpers\SelectDataHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\dictionary\searches\TestingEntrantSearch */

$this->title = 'QA';
$this->params['breadcrumbs'][] = $this->title;
$isDev = Yii::$app->user->can('dev') || Yii::$app->user->can('volunteering');
$columns = [
    ['class' => ActionColumn::class,
        'controller' => "testing-entrant",
        'template' => $isDev ? '{view} {update} {delete}' : '{view}',
    ],
    ['class' => \yii\grid\SerialColumn::class],
    'title',
    ['attribute'=>'department',
        'filter' => \dictionary\helpers\DictFacultyHelper::facultyListSetting(),
        'value'=>'departmentString'],
    'fio',
    ['attribute'=>'edu_level', 'filter'=> \dictionary\helpers\DictCompetitiveGroupHelper::getEduLevelsAbbreviated(),'value'=>'eduLevel'],
    ['attribute'=>'special_right', 'filter'=> \dictionary\helpers\DictCompetitiveGroupHelper::getSpecialRight(),'value'=>'specialRight'],
    ['attribute' => 'status',
        'format' => "raw",
        'filter' => array_filter(array_combine(array_keys((new TestingEntrant())->getStatusList()), array_column((new TestingEntrant())->getStatusList(), 'name'))),
        'value' => function($model) {
            return Html::tag('span', $model->statusName, ['class' => 'label label-'.$model->statusColor]);
        }],
];
if($isDev) {
    array_push($columns, ['attribute'=>'user_id',
        'filter' =>SelectDataHelper::dataSearchModel($searchModel, \olympic\helpers\auth\ProfileHelper::getVolunteering(),'user_id', 'profile.fio'),
        'value'=> function ($model) {  return $model->user_id ? $model->profile->fio.' '.$model->profile->user->email : "";}]);
}
?>
<div class="box">
    <div class="box-body">
        <p>
            <?= $isDev ? Html::a('Создать', ['testing-entrant/create'], ['class' => 'btn btn-success']) : "" ?>
        </p>
    </div>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'=> $searchModel,
            'columns' => $columns
        ]); ?>
    </div>
</div>

