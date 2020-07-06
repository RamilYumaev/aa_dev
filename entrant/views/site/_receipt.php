<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\ContractHelper;
use modules\entrant\widgets\cpk\InfoReceiptWidget;
use backend\widgets\adminlte\components\AdminLTE;
?>
<div class="box">
    <div class="box-header">
        <h4>Квитанции</h4>
    </div>
    <div class="box-body">
    <div class="row">
            <div class="col-md-3">
                <?= InfoReceiptWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'check-circle',
                    'status' => ContractHelper::STATUS_ACCEPTED,
                    'str' => "Проверенные", 'link' => ['/data-entrant/receipt-contract/index', 'status'=>ContractHelper::STATUS_ACCEPTED]])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoReceiptWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'circle',
                    'status' => ContractHelper::STATUS_VIEW,
                    'str' => "Взято в работу", 'link' => ['/data-entrant/receipt-contract/index', 'status'=> ContractHelper::STATUS_VIEW]])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoReceiptWidget::widget([
                    'colorBox' => AdminLTE::BG_ORANGE,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'plus',
                    'status' => ContractHelper::STATUS_WALT,
                    'str' => "Новые", 'link' => ['/data-entrant/receipt-contract/index', 'status'=>  ContractHelper::STATUS_WALT,]])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoReceiptWidget::widget([
                    'colorBox' => AdminLTE::BG_MAROON,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'check-remove',
                    'status' => ContractHelper::STATUS_NO_ACCEPTED,
                    'str' => "Непринятые", 'link' => ['/data-entrant/receipt-contract/index', 'status'=>ContractHelper::STATUS_NO_ACCEPTED]])
                ?>
            </div>
        </div>
    </div>
</div>
