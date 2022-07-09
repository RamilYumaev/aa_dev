<?php

use modules\entrant\widgets\other\PhotoOtherWidget;
use modules\entrant\widgets\passport\PassportMainWidget;
use modules\exam\helpers\ExamHelper;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\ExamStatement;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel modules\exam\searches\ExamStatementSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =  "Заявки на экзамен. Нарушение";

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        ['class' =>SerialColumn::class],
                    [
                    'attribute' => 'date',
                    'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to', \kartik\date\DatePicker::TYPE_INPUT),
                    'format' => 'date',],

                    [
                        'attribute' => 'exam_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, ExamHelper::examList() , 'exam_id', 'exam.discipline.name'),
                        'value'=> 'exam.discipline.name'
                    ],
                    [
                        'attribute' => 'entrant_user_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, ExamStatementHelper::entrantList() , 'entrant_user_id', 'profileEntrant.fio'),
                        'value'=> 'profileEntrant.fio'
                    ],
                    [
                        'attribute' => 'type',
                        'filter' => ExamStatementHelper::listTypes(),
                        'value'=> 'typeName'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => ExamStatementHelper::listStatus(),
                        'value'=> 'statusName'
                    ],

                    ['value' => function (ExamStatement $model) {
                           return  '<span class="label label-danger">Нарушения: '.$model->getViolation()->count().'</span>';
                    }, 'format'=> 'raw' ],
                    ['class' => ActionColumn::class, 'controller' => 'exam-statement', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>
