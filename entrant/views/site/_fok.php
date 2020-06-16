<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use backend\widgets\adminlte\Box;
use modules\entrant\widgets\cpk\InfoFokRemoveZosWidget;
use modules\entrant\widgets\cpk\InfoFokZosWidget;
use modules\entrant\widgets\cpk\InfoFokZukRemoveWidget;
use modules\entrant\widgets\cpk\InfoUserCozWidget;
use modules\entrant\widgets\cpk\StatementWidget;
use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\helpers\StatementHelper;
$new =  StatementHelper::STATUS_WALT;
?>
<?php Box::begin(
    [   "header" => "Заявления об участии в конкурсе",
        "type" => Box::TYPE_SUCCESS,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-3">
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_TEAL_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => $new,
            'str' => "Новые", 'link'=> ['data-entrant/statement/new']])?>
    </div>
    <div class="col-md-3">
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-3">
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
    <div class="col-md-3">
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_YELLOW_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'outdent',
            'status' => StatementHelper::STATUS_RECALL,
            'str' => "Отозванные",
            'link' => ['/data-entrant/statement/index', 'status'=> StatementHelper::STATUS_RECALL]])?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4> Новые заявления об участии в конкурсе</h4>
            </div>
            <div class="box-body">
            <?= StatementWidget::widget(['entrant'=> $jobEntrant, 'status' => $new])?>
            </div>
        </div>
    </div>

</div>
<?php Box::end() ?>

<?php Box::begin(
    [   "header" => "Отозванные заявления  об участии в конкурсе",
        "type" => Box::TYPE_INFO,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-4">
        <?= InfoFokZukRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => $new,
            'str' => "Новые", 'link'=> ['/data-entrant/statement-rejection/new']])?>
    </div>
    <div class="col-md-4">
        <?=  InfoFokZukRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement-rejection/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-4">
        <?=  InfoFokZukRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_MAROON,
            'entrant'=> $jobEntrant,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/data-entrant/statement-rejection/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
</div>

<?php Box::end() ?>

<?php Box::begin(
    [   "header" => "Заявления о согласии на зачисление",
        "type" => Box::TYPE_WARNING,
        "collapsable" => true,]) ?>
<div class="row">

    <div class="col-md-3">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_TEAL_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => $new,
            'str' => "Новые", 'link'=> ['/data-entrant/statement-consent-cg/new']])?>
    </div>
    <div class="col-md-3">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement-consent-cg/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-3">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/data-entrant/statement-consent-cg/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
    <div class="col-md-3">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_YELLOW_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'outdent',
            'status' => StatementHelper::STATUS_RECALL,
            'str' => "Отозванные",
            'link' => ['/data-entrant/statement-consent-cg/index', 'status'=> StatementHelper::STATUS_RECALL]])?>
    </div>
</div>

<?php Box::end() ?>

<?php Box::begin(
    [   "header" => "Отозванные заявления   о согласии на зачисление",
        "type" => Box::TYPE_DANGER,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-4">
        <?= InfoFokRemoveZosWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => $new,
            'str' => "Новые", 'link'=> ['/data-entrant/statement-rejection/consent-new']])?>
    </div>
    <div class="col-md-4">
        <?=  InfoFokRemoveZosWidget::widget([
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement-rejection/consent-index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-4">
        <?=  InfoFokRemoveZosWidget::widget([
            'colorBox' => AdminLTE::BG_MAROON,
            'entrant'=> $jobEntrant,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/data-entrant/statement-rejection/consent-index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
</div>

<?php Box::end() ?>

