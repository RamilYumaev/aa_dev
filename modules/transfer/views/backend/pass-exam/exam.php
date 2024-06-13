<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\transfer\models\PassExam;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\transfer\search\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $exam int*/
$list = (new PassExam)->listType();
$exam = (int)$exam;
$this->title = "Аттестационные испытания. ".(key_exists($exam, $list)? "(".$list[$exam].")":"");

$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
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
                            'attribute' => 'statement.user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\transfer\models\StatementTransfer::find()->joinWith('profileUser')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column(), 'user_id', 'profileUser.fio'),
                            'value'=> 'statement.profileUser.fio'
                    ],
                    [
                        'attribute' => 'type',
                        'label' => 'Тип',
                        'filter' => (new \modules\transfer\models\TransferMpgu())->listTypeShort(),
                        'value' => 'statement.transferMpgu.typeNameShort',
                    ],
                    [
                        'attribute' => 'faculty_id',
                        'label' =>'Факультет',
                        'filter' => \dictionary\helpers\DictFacultyHelper::facultyList(),
                        'value' => function($model) {
                            return $model->statement->faculty ? $model->statement->faculty->full_name : "";
                        }
                    ],
                    [
                        'attribute' => 'finance',
                        'label' =>'Тип финансирования',
                        'filter' => DictCompetitiveGroupHelper::listFinances(),
                        'value' => function($model) {
                            return $model->statement->finance ? $model->statement->typeFinance : "";
                        }
                    ],
                    ['attribute'=> 'success_exam',
                        'label' =>'Аттест. испытания',
                        'filter'=> $list,
                            'value' => function ($model) {
                     return  $model->successExam;
                    }],
                    [
                        'format' => 'raw',
                        'filter'=> $list,
                        'value' => function ($model) use ($list) {
                            return  !$model->success_exam? Html::a($list[PassExam::SUCCESS],
                                ['exam-status', 'id' => $model->id, 'status'=> PassExam::SUCCESS],
                                ['data'=>['confirm'=> 'Вы уверены, что хотите это сделать?'], 'class'=> 'btn btn-block btn-success']).
                                Html::a($list[PassExam::DONE],
                                    ['exam-status', 'id' => $model->id, 'status'=> PassExam::DONE],
                                    ['data'=> ['confirm'=> 'Вы уверены, что хотите это сделать?'],  'class'=> 'btn btn-block btn-danger']) :
                                Html::a($list[PassExam::NO_DATA],
                                    ['exam-status', 'id' => $model->id, 'status'=> PassExam::NO_DATA],
                                    ['data'=> ['confirm'=> 'Вы уверены, что хотите это сделать?'],  'class'=> 'btn btn-block  btn-warning']);

                        }],
                    ['class' => ActionColumn::class, 'controller' => 'statement', 'template' => '{view}', 'buttons'=> ['view' =>
                        function ($url, $model, $key) {
                              return   Html::a("Просмотр",
                                  ['statement/view', 'id' => $model->statement->id, ],
                                  ['class'=> 'btn btn-block btn-info']);
                          }
                    ]]
                ],
            ]); ?>
        </div>
    </div>
</div>

