<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\transfer\search\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */
$st= StatementHelper::statusJobName($status);
$status = $st ? " (".$st.")" : "";

$this->title = "Заявления". $status;

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
                            'attribute' => 'user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\transfer\models\StatementTransfer::find()->joinWith('profileUser')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column(), 'user_id', 'profileUser.fio'),
                            'value'=> 'profileUser.fio'
                    ],
                    [
                        'attribute' => 'type',
                        'label' => 'Тип',
                        'filter' => (new \modules\transfer\models\TransferMpgu())->listTypeShort(),
                        'value' => 'transferMpgu.typeNameShort',
                    ],
                    [
                        'attribute' => 'finance',
                        'filter' => DictCompetitiveGroupHelper::listFinances(),
                        'value' => function($model) {
                            return $model->finance ? $model->typeFinance : "";
                        }
                    ],
                    [
                        'attribute' => 'faculty_id',
                        'label' => 'Институт/Факультет',
                        'filter' =>  SelectDataHelper::dataSearchModel($searchModel,\dictionary\helpers\DictFacultyHelper::facultyList(), 'faculty_id', 'faculty_id'),
                        'value' => function($model) {
                            return $model->faculty_id ? \dictionary\helpers\DictFacultyHelper::facultyName( $model->faculty_id) : "";
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [  'format' => 'raw',
                            'value' => function ($model) {
                     return ' <span class="label label-' .StatementHelper::colorName($model->status).'">'.$model->statusNameJob.'</span>';
                                         }],
                    ['class' => ActionColumn::class, 'controller' => 'statement', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

