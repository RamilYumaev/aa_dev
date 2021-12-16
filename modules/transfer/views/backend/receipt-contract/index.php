<?php

use modules\entrant\helpers\ContractHelper;
use modules\entrant\searches\grid\ContractColumn;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\ReceiptContractSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */
$st= ContractHelper::statusName($status);
$status = !is_null($st) ? " (".$st.")" : "";
$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Договоры ПиВ', 'url' => ['default/contract']];
$this->title = "Квитанции" .$status;
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
                    [       'attribute' => 'user_id',
                        'label' => 'Студент',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\transfer\models\StatementTransfer::find()->joinWith('profileUser')->andWhere(['finance'=> 2])->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column(), 'user_id', 'profileUser.fio'),
                            'value'=> 'contractCg.statementTransfer.profileUser.fio'

                    ],
                    [   'attribute' => 'number',
                        'value' => 'contractCg.number'
                    ],
                    'bank',
                    'pay_sum',
                    [
                        'attribute' => 'date',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'date',
                    ],
                    [ 'attribute' => 'status_id',
                        'class'=> ContractColumn::class,
                        'filter' => ContractHelper::statusList(),

                    ],
                    ['class' => ActionColumn::class, 'controller' => 'receipt-contract', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

