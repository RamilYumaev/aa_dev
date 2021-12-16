<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\ContractHelper;
use modules\transfer\widgets\info\InfoReceiptWidget;
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
                'colorBox' => AdminLTE::BG_ORANGE,
                'icon'=> 'plus',
                'status' => ContractHelper::STATUS_WALT,
                'str' => "Новые", 'link' => ['receipt-contract/index', 'status'=>  ContractHelper::STATUS_WALT,]])
            ?>
        </div>
            <div class="col-md-3">
                <?= InfoReceiptWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                    'icon'=> 'circle',
                    'status' => ContractHelper::STATUS_VIEW,
                    'str' => "Взято в работу", 'link' => ['receipt-contract/index', 'status'=> ContractHelper::STATUS_VIEW]])
                ?>
            </div>
            
        <div class="col-md-3">
            <?= InfoReceiptWidget::widget([
                'colorBox' => AdminLTE::BG_OLIVE,
                'icon'=> 'check-circle',
                'status' => ContractHelper::STATUS_ACCEPTED,
                'str' => "Проверенные", 'link' => ['receipt-contract/index', 'status'=>ContractHelper::STATUS_ACCEPTED]])
            ?>
        </div>
            <div class="col-md-3">
                <?= InfoReceiptWidget::widget([
                    'colorBox' => AdminLTE::BG_MAROON,
                    'icon'=> 'check-remove',
                    'status' => ContractHelper::STATUS_NO_ACCEPTED,
                    'str' => "Непринятые", 'link' => ['receipt-contract/index', 'status'=>ContractHelper::STATUS_NO_ACCEPTED]])
                ?>
            </div>
        </div>
    </div>
</div>
