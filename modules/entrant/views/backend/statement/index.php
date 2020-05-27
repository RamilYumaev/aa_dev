<?php

use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Заявления об участии в конкурсе";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                            'attribute' => 'user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatement('user_id',  'profileUser.fio'), 'user_id', 'profileUser.fio'),
                            'value'=> 'profileUser.fio'

                    ],
                    [
                        'attribute' => 'faculty_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatement('faculty_id',  'faculty.full_name'), 'faculty_id', 'faculty.full_name'),
                         'value' => 'faculty.full_name'
                    ],
                    [
                        'attribute' => 'speciality_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatement('speciality_id', 'speciality.codeWithName'), 'speciality_id',  'speciality.codeWithName'),
                         'value' => 'speciality.codeWithName'
                    ],
                    [
                        'attribute' => 'edu_level',
                        'filter' => StatementHelper::columnStatement('edu_level',  'eduLevel'),
                        'value'=>'eduLevel',
                    ],
                    [
                        'attribute' => 'special_right',
                        'filter' => StatementHelper::columnStatement('special_right',  'specialRight'),
                         'value' => 'specialRight'
                    ],                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [
                        'class' => \modules\entrant\searches\grid\StatementColumn::class,
                    ],
                    ['value' => function ($model) {
                           return Html::a("ЭУК в АИС", ['communication/export-statement', 'user' => $model->user_id, 'statement' => $model->id], ['data-method' => 'post', 'class' => 'btn btn-success']);
                    }, 'format'=> 'raw' ],
                    ['class' => ActionColumn::class, 'controller' => 'statement', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>
