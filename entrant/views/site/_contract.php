<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\ContractHelper;
use modules\entrant\widgets\cpk\InfoContractWidget;
use backend\widgets\adminlte\components\AdminLTE;


?>
<div class="box">
    <div class="box-header">
        <h4>Договоры</h4>
    </div>
    <div class="box-body">
    <div class="row">
        <div class="col-md-3">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_YELLOW,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'check-remove',
                    'status' => ContractHelper::STATUS_NEW,
                    'str' => "Неотправленные", 'link' => ['/data-entrant/agreement-contract/index', 'status'=>ContractHelper::STATUS_NEW]])
                ?>
            </div>
        <div class="col-md-3">
            <?= InfoContractWidget::widget([
                'colorBox' => AdminLTE::BG_ORANGE,
                'entrant'=> $jobEntrant,
                'icon'=> 'plus',
                'status' => ContractHelper::STATUS_WALT,
                'str' => "Новые", 'link' => ['/data-entrant/agreement-contract/index', 'status'=>  ContractHelper::STATUS_WALT,]])
            ?>
        </div>
        <div class="col-md-3">
            <?= InfoContractWidget::widget([
                'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                'entrant'=> $jobEntrant,
                'icon'=> 'circle',
                'status' => ContractHelper::STATUS_VIEW,
                'str' => "Взято в работу", 'link' => ['/data-entrant/agreement-contract/index', 'status'=> ContractHelper::STATUS_VIEW]])
            ?>
        </div>
            <div class="col-md-3">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'check-circle',
                    'status' => ContractHelper::STATUS_ACCEPTED,
                    'str' => "Проверенные", 'link' => ['/data-entrant/agreement-contract/index', 'status'=>ContractHelper::STATUS_ACCEPTED]])
                ?>
            </div>


        </div>
        <div class="row">
            <div class="col-md-4">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_MAROON,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'check-remove',
                    'status' => ContractHelper::STATUS_NO_ACCEPTED,
                    'str' => "Непринятые", 'link' => ['/data-entrant/agreement-contract/index', 'status'=>ContractHelper::STATUS_NO_ACCEPTED]])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_PURPLE_ACTIVE,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'ok',
                    'status' => ContractHelper::STATUS_SUCCESS,
                    'str' => "Подписанные", 'link' => ['/data-entrant/agreement-contract/index', 'status'=> ContractHelper::STATUS_SUCCESS]])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_RED,
                    'entrant'=> $jobEntrant,
                    'icon'=> 'remove',
                    'status' => ContractHelper::STATUS_NO_REAL,
                    'str' => "Недействительные", 'link' => ['/data-entrant/agreement-contract/index', 'status' => ContractHelper::STATUS_NO_REAL,]])
                ?>
            </div>
        </div>
    </div>
</div>
