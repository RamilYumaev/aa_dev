<?php

use modules\entrant\widgets\other\PhotoOtherWidget;
use modules\entrant\widgets\passport\PassportMainWidget;
use modules\exam\helpers\ExamHelper;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\ExamStatement;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\exam\widgets\exam\TestAttemptStatementWidget;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel modules\exam\searches\ExamStatementSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->controller->action->id == 'my-list' ? "Ваши заявки на экзамен" : "Новые заявки на экзамен";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <div class="box-header">
            <?php if(Yii::$app->controller->action->id == 'index' && Yii::$app->user->can('dev')): ?>
                <?= $this->render('_buttons') ?>
            <?php endif;?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function(ExamStatement $model){
                        return ['class' => 'warning'];
                },
                'afterRow' =>function (ExamStatement $model, $key, $index, $grid)
                    {
                        if($model->proctor_user_id) {
                        return '<tr><td colspan="3">'.PhotoOtherWidget::widget(['view'=> 'file-backend', 'userId'=> $model->entrant_user_id]).'</td><td colspan="2">'.
                            PassportMainWidget::widget(['view'=> 'file-backend', 'userId'=> $model->entrant_user_id]).'</td><td>'.
                            $model->profileEntrant->phone.'<br/>'.
                            ($model->statusWalt() ? Html::a('Допустить', ['exam-statement/status', 'id' => $model->id, 'status' => ExamStatementHelper::SUCCESS_STATUS],['class'=> "btn btn-success btn-block", 'data-confirm'=> "Вы уверены, что хотите допустить?"]) : "").
                            ($model->statusSuccess() && !$model->getViolation()->count() ? Html::a('Завершить', ['exam-statement/status', 'id' => $model->id, 'status' => ExamStatementHelper::END_STATUS],['class'=> "btn btn-primary btn-block", 'data-confirm'=> "Вы уверены, что хотите завершить?"]) : "").
                            ($model->statusWalt() ? Html::a('Редактировать BigBlueButton', ['exam-statement/src', 'id' => $model->id],
                                   [  'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Редактирование ссылки', 'class' => 'btn btn-info btn-block']) : "")
                            . Html::a('BigBlueButton', $model->src_bbb,['class'=> "btn bg-purple btn-block",  'target'=>'_blank']).
                            (!$model->statusError() ? Html::a('Резервный/Нарушение', ['exam-statement/message', 'id' => $model->id],['data-pjax' => 'w123', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить сообщение', 'class'=> "btn btn-warning btn-block"]) : "").
                            ($model->statusSuccess() ?  Html::a('Добавить нарушение', ['exam-violation/create','examStatementId' => $model->id],
                                          ['data-pjax' => 'w7', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить нарушение', 'class'=>'btn btn-danger btn-block']) : "").
                                      Html::a('Просмотр', ['exam-statement/view', 'id' => $model->id],['class'=> "btn btn-info btn-block"]).
                                        '<br/> <center><span class="'.ExamStatementHelper::listStatusColor()[$model->status].'">'.$model->statusName.'</span></center>
                                           <br/> <center><span class="label label-danger">Нарушения '.$model->getViolation()->count().'</span></center>
                                            </td></tr><tr>
                                            <td colspan="6">'.TestAttemptStatementWidget::widget(['userId'=> $model->entrant_user_id, 'examId' => $model->exam_id, 'type' => $model->type]).'</td>
                                            </tr>';
                        }
                    },
                'columns' => [
                        ['class' =>SerialColumn::class],
                        [
                    'attribute' => 'date',
                    'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to', \kartik\date\DatePicker::TYPE_INPUT),
                     'value' => 'dateView'],

                    [
                        'attribute' => 'time',
                        'filter' => ExamStatementHelper::timeList(),
                        'value' => 'time'],

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
                    ['value' => function (ExamStatement $model) {
                           return !$model->proctor_user_id ?
                               Html::a('Взять в работу', ['exam-statement/src', 'id' => $model->id],
                                   [  'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Добавление ссылки', 'class' => 'btn btn-info']) : '';
                    }, 'format'=> 'raw' ],
                ],
            ]); ?>
        </div>
    </div>
</div>
