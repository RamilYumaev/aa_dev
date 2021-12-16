<?php

use modules\dictionary\helpers\JobEntrantHelper;
use modules\transfer\helpers\ContractHelper;
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
    $this->title = "Договоры" .$status;
$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Договоры ПиВ', 'url' => ['default/contract']];
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
                            'attribute' => 'user_id',
                             'label' => 'Студент',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\transfer\models\StatementTransfer::find()->joinWith('profileUser')->andWhere(['finance'=> 2])->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column(), 'user_id', 'profileUser.fio'),
                            'value'=> 'statementTransfer.profileUser.fio'
                    ],
                    'number',
                    ['header' => "Конкурсная группа",
                        'attribute' => 'cg_id',
                        'value' => 'statementTransfer.cg.fullNameV'
                    ],
                    ['header' => "Факультет",
                        'attribute' => 'cg_id',
                        'value' => 'statementTransfer.cg.faculty.full_name'
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [  'attribute' => 'status_id',
                          'value'=>'statusName',
                        'filter' => ContractHelper::statusList(),
                    ],
                    ['class' => ActionColumn::class, 'controller' => 'agreement-contract', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

