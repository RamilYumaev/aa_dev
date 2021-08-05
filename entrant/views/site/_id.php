<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\cpk\CountPotentialUserCozWidget;
use modules\entrant\widgets\cpk\CountUserCozFokWidget;
use modules\entrant\widgets\cpk\CountUserCozWidget;
use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\widgets\cpk\CountUserErrorFilesCozWidget;
use modules\entrant\widgets\cpk\FileCozWidget;
use modules\entrant\widgets\cpk\InfoZidWidget;
use modules\entrant\widgets\file\FileWidget;

?>

<div class="row">
    <div class="col-md-4">
        <?= InfoZidWidget::widget([
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "ЗИД (Рассмотренные)", 'link' => ['/data-entrant/statement-individual-achievements/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])
        ?>
    </div>
    <div class="col-md-4">
        <?= InfoZidWidget::widget([
            'colorBox' => AdminLTE::BG_LIGHT_BLUE,
            'entrant'=> $jobEntrant,
            'icon'=> 'eye-open',
            'status' => StatementHelper::STATUS_VIEW,
            'str' => "ЗИД (Взято в работу)", 'link' => ['/data-entrant/statement-individual-achievements/index', 'status'=> StatementHelper::STATUS_VIEW]])
        ?>
    </div>
    <div class="col-md-4">
        <?= InfoZidWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus',
            'status' => StatementHelper::STATUS_WALT,
            'str' => "ЗИД (новые)", 'link' => ['/data-entrant/statement-individual-achievements/index', 'status'=> StatementHelper::STATUS_WALT]])
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4> Загруженные(обновленные) файлы ЗИД</h4>
            </div>
            <div class="box-body">
                <?= \modules\entrant\widgets\cpk\FileZIDWidget::widget(['eduLevel'=> $eduLevel])?>
            </div>
        </div>
    </div>

</div>