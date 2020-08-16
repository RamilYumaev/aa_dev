<?php

use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\searches\grid\ContractColumn;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementAgreementContractSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$st= ContractHelper::statusName($searchModel->status);
$status = !is_null($st) ? " (".$st.")" : "";
$faculty= !is_null($searchModel->faculty) ?  " (".JobEntrantHelper::listCategories()[$searchModel->faculty].")" : "";
$eduLevel= !is_null($searchModel->edulevel) ?  " (Аспирантура)" : "";
    $this->title = "Договоры" .$status.$faculty.$eduLevel;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    [
                            'attribute' => 'statementCg.statement.user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementAgreement('user_id',  'profileUser', 'CONCAT(last_name, \' \', first_name, \' \', patronymic)'), 'user_id', 'statementCg.statement.profileUser.fio'),
                            'value'=> 'statementCg.statement.profileUser.fio'
                    ],
                    'number',
                    [
                        'attribute' => 'statementCg.statement.faculty_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementAgreement('faculty_id',  'faculty', 'full_name'), 'faculty_id', 'statementCg.statement.faculty.full_name'),
                         'value' => 'statementCg.statement.faculty.full_name'
                    ],
                    ['header' => "Конкурсная группа",
                        'attribute' => 'statementCg.cg.id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementAgreementCg('cg_id',  'fullNameB'), 'cg', 'statementCg.cg.fullNameB'),
                        'value' => 'statementCg.cg.fullNameB'
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [  'attribute' => 'status_id',
                        'class'=> ContractColumn::class,
                        'filter' => ContractHelper::statusList(),

                    ],
                    ['class' => ActionColumn::class, 'controller' => 'agreement-contract', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

