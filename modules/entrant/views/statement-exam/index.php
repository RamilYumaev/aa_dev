<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $exam string */
$status = $exam == 'vi' ? "ВИ" : "ЕГЭ-ВИ";

$this->title = "Заявления об участии в конкурсе". $status;

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                            'attribute' => 'user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnExamStatement('user_id',  'profileUser', 'CONCAT(last_name, \' \', first_name, \' \', patronymic)', $exam), 'user_id', 'profileUser.fio'),
                            'value'=> 'profileUser.fio'

                    ],
                    [
                        'attribute' => 'faculty_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnExamStatement('faculty_id',  'faculty', 'full_name', $exam), 'faculty_id', 'faculty.full_name'),
                         'value' => 'faculty.full_name'
                    ],
                    [
                        'attribute' => 'speciality_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnExamStatement('speciality_id', 'speciality', 'CONCAT(code, \' \', name)', $exam), 'speciality_id',  'speciality.codeWithName'),
                         'value' => 'speciality.codeWithName'
                    ],
                    [
                        'attribute' => 'edu_level',
                        'filter' => DictCompetitiveGroupHelper::getEduLevels(),
                        'value'=>'eduLevel',
                    ],
                    [
                        'attribute' => 'special_right',
                        'filter' => DictCompetitiveGroupHelper::getSpecialRight(),
                         'value' => 'specialRight'
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [
                        'class' => \modules\entrant\searches\grid\StatementColumn::class,
                    ],
//                    ['value' => function ($model) {
//                           return $model->status == StatementHelper::STATUS_WALT ?
//                               Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
//                                   ['communication/export-statement',
//                                   'user' => $model->user_id, 'statement' => $model->id],
//                                   ['data-method' => 'post', 'class' => 'btn btn-success']) : '';
//                    }, 'format'=> 'raw' ],
                    ['class' => ActionColumn::class, 'controller' => 'statement', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

