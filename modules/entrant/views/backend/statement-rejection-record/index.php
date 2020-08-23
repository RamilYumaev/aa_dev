<?php

use entrant\assets\modal\ModalAsset;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementRejectionRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

ModalAsset::register($this);
$this->title = "Заявление об исключении из приказа о зачислении";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function(StatementRejectionRecord $model){
                    return ['class' => 'warning'];
                },
                'afterRow' =>function (StatementRejectionRecord $model, $key, $index, $grid)
                {
                        return '<tr><td colspan="3">'.
                            FileListBackendWidget::widget(['record_id' => $model->id, 'isCorrect' => $model->isStatusAccepted(), 'model' => StatementRejectionRecord::class, 'userId' => $model->user_id])
                            .'</td>'.'<td>'.
                            $model->profileUser->phone.'<br /> incoming_id -'. $model->profileUser->ais->incoming_id.
                            Html::a('Скачать заявление', ['statement-rejection-record/pdf', 'id' =>  $model->id], ['class' => 'btn btn-large btn-warning  btn-block']).
                            Html::a('Взять в работу', ['statement-rejection-record/status', 'id' =>  $model->id, 'status'=> StatementHelper::STATUS_VIEW], ['class' => 'btn btn-large btn-info  btn-block']).
                            Html::a('Принять', ['statement-rejection-record/status', 'id' =>  $model->id, 'status'=> StatementHelper::STATUS_ACCEPTED], ['class' => 'btn btn-large btn-success  btn-block']).
                            Html::a('Отклонить', ['statement-rejection-record/status', 'id' =>  $model->id, 'status'=> StatementHelper::STATUS_NO_ACCEPTED], ['class' => 'btn btn-large btn-danger btn-block'])
                            .'</td></tr>';
                },
                'columns' => [
                    [
                            'attribute' => 'user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnRejectionRecord('statement_rejection_record.user_id',  'profileUser', 'CONCAT(last_name, \' \', first_name, \' \', patronymic)'), 'user_id', 'profileUser.fio'),
                            'value'=> 'profileUser.fio'

                    ],
                    [
                            'attribute' => 'cg',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnRejectionRecordCg('cg_id',  'fullNameB'), 'cg', 'cg.fullNameB'),
                         'label' => "Конкурсная группа",
                         'value' => 'cg.fullNameB'
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => StatementHelper::statusListJobEntrant(),
                        'format'=> 'raw' ,
                        'value' => function ( StatementRejectionRecord $model) {
                            return Html::tag('span', Html::encode($model->statusNameJob), ['class' => 'label label-'.StatementHelper::colorName($model->status)]);
                        }],
                ],
            ]); ?>
        </div>
    </div>
</div>

