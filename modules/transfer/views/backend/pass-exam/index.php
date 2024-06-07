<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use entrant\assets\modal\ModalAsset;
use modules\transfer\models\PassExam;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\transfer\search\PassExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$list = (new PassExam)->listType();
ModalAsset::register($this);
$this->title = "Данные аттестации";
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
                            'label' => 'Студент',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\transfer\models\StatementTransfer::find()->joinWith('profileUser')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column(), 'user_id', 'profileUser.fio'),
                            'value'=> 'statement.profileUser.fio'
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Дата создания',
                        'value'=> 'statement.created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [
                        'attribute' => 'finance',
                        'label' =>'Тип финансирования',
                        'filter' => DictCompetitiveGroupHelper::listFinances(),
                        'value' => function($model) {
                            return $model->statement->finance ? $model->statement->typeFinance : "";
                        }
                    ],
                    [   'attribute' => 'is_pass',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'filter' => [PassExam::SUCCESS => 'Допущен', PassExam::DANGER => 'Не допущен'],
                        'value' => function (PassExam $model) {
                            return ' <span class="label label-' .($model->isPassYes() ? 'success' : 'danger').'">'.($model->isPassYes() ? 'Допущен' : 'Не допущен').'</span>';
                        }],
                    ['attribute'=> 'success_exam',
                        'label' =>'Аттест. испытания',
                        'filter'=> $list,
                        'value' => function ($model) {
                            return  $model->successExam;
                        }],
                    [   'attribute' => 'agree',
                        'label' => 'Результат',
                            'format' => 'raw',
                        'filter' => [1 => 'Согласен', 2 => 'Не согласен'],
                            'value' => function (PassExam $model) {
                     return  is_null($model->agree) ? "": ' <span class="label label-' .($model->agree == 1? 'success' : 'danger').'">'.($model->agree == 1 ? 'Согласен' : 'Не согласен').'</span>';
                                         }],
                    [ 'format' => 'raw',
                            'value'  => function (PassExam $model) {
                        return  Html::a('Просмотр', ['statement/view', 'id' => $model->statement_id]).'<br/>'.
                            ($model->isPassYes() && !$model->examStatement && $model->success_exam == $model::NO_DATA ? Html::a("Допуск к тестированию",
                                ['/data-exam/exam-statement/transfer-date', 'user_id'=> $model->statement->user_id],['data-pjax' => 'w15', 'data-toggle' => 'modal', 'data-target' => '#modal',
                                    'data-modalTitle' =>'Допуск к тестированию', 'class' => 'btn btn-sm btn-danger']) : "");
                    },],
                ],
            ]); ?>
        </div>
    </div>
</div>

