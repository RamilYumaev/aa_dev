<?php

use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\models\Event;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\searches\EventSearch */


$this->title = 'Собрание первокурсников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['class' => ActionColumn::class,
                        'controller' => "event",
                        'template' => '{update} {delete}',
                    ],
                    ['attribute' => 'type', 'filter' => (new Event())->getTypes(), 'value' => 'typeName'],
                    [ 'attribute' => 'faculty_id', 'value' => 'facultyIds',
                        'filter'=> SelectDataHelper::dataSearchModel($searchModel, \dictionary\helpers\DictFacultyHelper::facultyList(), 'faculty_id', 'facultyIds')],
                    [ 'attribute' => 'form_id', 'value' => 'formIds',
                        'filter'=> SelectDataHelper::dataSearchModel($searchModel, \dictionary\helpers\DictCompetitiveGroupHelper::getEduForms(), 'form_id', '')],
                    [ 'attribute' => 'edu_level',  'value' => 'eduLevelIds',
                        'filter'=> SelectDataHelper::dataSearchModel($searchModel,  \dictionary\helpers\DictCompetitiveGroupHelper::getEduLevelsAbbreviated(), 'edu_level', '')],
                    [ 'attribute' => 'cg_id',  'value' => 'cgIds',
                        'filter'=> SelectDataHelper::dataSearchModel($searchModel, Event::columnCg(), 'cg_id', 'cgIds')],
                    'place',
                    'date:datetime',
                    ['attribute' => 'name_src', 'value' =>function(Event $model) {
                         return Html::a($model->name_src, $model->src);
                    }, 'format'=>'raw'],

                ]
            ]); ?>
        </div>
    </div>
</div>
