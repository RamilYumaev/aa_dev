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
/* @var $searchModel modules\transfer\search\PassExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$list = (new PassExam)->listType();

$this->title = "Аттестация";
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
                    [   'attribute' => 'is_pass',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'filter' => [PassExam::SUCCESS => 'Допущен', PassExam::DANGER => 'Недопущен'],
                        'value' => function (PassExam $model) {
                            return ' <span class="label label-' .($model->isPassYes() ? 'success' : 'danger').'">'.($model->isPassYes() ? 'Допущен' : 'Недопущен').'</span>';
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
                            'value'  => function ($model) {
                        return  Html::a('Просмотр', ['statement/view', 'id' => $model->statement_id]);
                    },],
                ],
            ]); ?>
        </div>
    </div>
</div>

