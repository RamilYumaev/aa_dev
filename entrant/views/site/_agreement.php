<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\AgreementHelper;
use modules\entrant\widgets\cpk\InfoAgreementWidget;
use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\helpers\StatementHelper;

?>
<div class="box">
    <div class="box-header">
        <h4>Целевые договоры</h4>
    </div>
    <div class="box-body">
    <div class="row">
        <div class="col-md-3">
            <?= InfoAgreementWidget::widget([
                'colorBox' => AdminLTE::BG_OLIVE,
                'entrant'=> $jobEntrant,
                'icon'=> 'check-circle',
                'status' => AgreementHelper::STATUS_ACCEPTED,
                'str' => "Принятые", 'link' => ['/data-entrant/agreement/index', 'status'=> AgreementHelper::STATUS_ACCEPTED]])
            ?>
        </div>
        <div class="col-md-3">
            <?= InfoAgreementWidget::widget([
                'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                'entrant'=> $jobEntrant,
                'icon'=> 'circle',
                'status' => AgreementHelper::STATUS_VIEW,
                'str' => "Взято в работу", 'link' => ['/data-entrant/agreement/index', 'status'=> AgreementHelper::STATUS_VIEW]])
            ?>
        </div>
        <div class="col-md-3">
            <?= InfoAgreementWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus',
            'status' => AgreementHelper::STATUS_NEW,
            'str' => "Новые", 'link' => ['/data-entrant/agreement/index', 'status'=>  AgreementHelper::STATUS_NEW,]])
            ?>
        </div>
        <div class="col-md-3">
            <?= InfoAgreementWidget::widget([
                'colorBox' => AdminLTE::BG_RED,
                'entrant'=> $jobEntrant,
                'icon'=> 'remove',
                'status' => AgreementHelper::STATUS_NO_ACCEPTED,
                'str' => "Непринятые", 'link' => ['/data-entrant/agreement/index', 'status' => AgreementHelper::STATUS_NO_ACCEPTED,]])
            ?>
        </div>
    </div>
    </div>
</div>
