<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\transfer\helpers\ContractHelper;
use modules\transfer\widgets\info\InfoContractWidget;
use backend\widgets\adminlte\components\AdminLTE;


?>
<div class="box">
    <div class="box-body">
    <div class="row">
        <div class="col-md-3">
            <?= InfoContractWidget::widget([
                'colorBox' => AdminLTE::BG_YELLOW,
                'icon'=> 'radio',
                'status' => ContractHelper::STATUS_NEW,
                'str' => "Неотправленные", 'link' => ['agreement-contract/index', 'status'=>ContractHelper::STATUS_NEW]])
            ?>
        </div>
        <div class="col-md-3">
            <?= InfoContractWidget::widget([
                'colorBox' => AdminLTE::BG_ORANGE,
                'icon'=> 'plus',
                'status' => ContractHelper::STATUS_WALT,
                'str' => "Новые", 'link' => ['agreement-contract/index', 'status'=>  ContractHelper::STATUS_WALT]])
            ?>
        </div>
        <div class="col-md-3">
            <?= InfoContractWidget::widget([
                'colorBox' => AdminLTE::BG_BLUE,
                'icon'=> 'time',
                'status' => ContractHelper::STATUS_VIEW,
                'str' => "Взято в работу", 'link' => ['agreement-contract/index', 'status'=>  ContractHelper::STATUS_VIEW,]])
            ?>
        </div>
        <div class="col-md-3">
            <?= InfoContractWidget::widget([
                'colorBox' => AdminLTE::BG_RED,
                'icon'=> 'remove',
                'status' => ContractHelper::STATUS_NO_ACCEPTED,
                'str' => "Отклоненные", 'link' => ['agreement-contract/index', 'status'=>  ContractHelper::STATUS_NO_ACCEPTED,]])
            ?>
        </div>
    </div>
        <div class="row">
        <div class="col-md-3">
            <?= InfoContractWidget::widget([
                'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                'icon'=> 'check',
                'status' => ContractHelper::STATUS_CREATED,
                'str' => "Сформированые", 'link' => ['agreement-contract/index', 'status'=> ContractHelper::STATUS_CREATED]])
            ?>
        </div>
            <div class="col-md-3">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_LIME,
                    'icon'=> 'circle',
                    'status' => ContractHelper::STATUS_ACCEPTED_STUDENT,
                    'str' => "Одобренные", 'link' => ['agreement-contract/index', 'status'=>ContractHelper::STATUS_ACCEPTED_STUDENT]])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_YELLOW_ACTIVE,
                    'icon'=> 'warning',
                    'status' => ContractHelper::STATUS_FIX,
                    'str' => "На испрвление", 'link' => ['agreement-contract/index', 'status'=>ContractHelper::STATUS_FIX]])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'icon'=> 'check-circle',
                    'status' => ContractHelper::STATUS_ACCEPTED,
                    'str' => "Принятые", 'link' => ['agreement-contract/index', 'status'=>ContractHelper::STATUS_ACCEPTED]])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_PURPLE_ACTIVE,
                    'icon'=> 'send',
                    'status' => ContractHelper::STATUS_SEND_SUCCESS,
                    'str' => "На подписание", 'link' => ['agreement-contract/index', 'status'=> ContractHelper::STATUS_SEND_SUCCESS]])
                ?>
            </div>
            <div class="col-md-6">
                <?= InfoContractWidget::widget([
                    'colorBox' => AdminLTE::BG_AQUA_ACTIVE,
                    'icon'=> 'list',
                    'status' => ContractHelper::STATUS_SUCCESS,
                    'str' => "Подписанные", 'link' => ['agreement-contract/index', 'status'=> ContractHelper::STATUS_SUCCESS]])
                ?>
            </div>
        </div>
    </div>
</div>
