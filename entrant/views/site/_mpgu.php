<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\widgets\cpk\CountUserCozWidget;
use modules\entrant\widgets\cpk\InfoFokRemoveZosWidget;
use modules\entrant\widgets\cpk\InfoFokZosWidget;
use modules\entrant\widgets\cpk\InfoFokZukCgRemoveWidget;
use modules\entrant\widgets\cpk\InfoFokZukRemoveWidget;
use modules\entrant\widgets\cpk\InfoUserCozWidget;
use modules\entrant\widgets\cpk\InfoZidWidget;
use modules\entrant\widgets\cpk\StatementWidget;
use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\helpers\StatementHelper;
use \modules\dictionary\helpers\JobEntrantHelper;

?>
<div class="row">
    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'type' => 2,
            'colorBox' => AdminLTE::BG_BLUE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::MPGU_SR,
            'str' => "Абитуриенты Квотники и БВИ (новые)", 'link' => ['data-entrant/default/index', 'type' => 2, 'is_id' => JobEntrantHelper::MPGU_SR]]) ?>
        <?= CountUserCozWidget::widget([
            'type' => 2,
            'colorBox' => AdminLTE::BG_BLUE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::MPGU_PP,
            'str' => "Абитуриенты с ПП (новые)", 'link' => ['data-entrant/default/index', 'type' => 2, 'is_id' => JobEntrantHelper::MPGU_PP]]) ?>
    </div>

    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'type' => 1,
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::MPGU_SR,
            'str' => "Абитуриенты Квотники и БВИ (принятые)", 'link' => ['data-entrant/default/index', 'type' => 1, 'is_id' => JobEntrantHelper::MPGU_SR]]) ?>
        <?= CountUserCozWidget::widget([
            'type' => 1,
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::MPGU_PP,
            'str' => "Абитуриенты с ПП (принятые)", 'link' => ['data-entrant/default/index', 'type' => 1, 'is_id' => JobEntrantHelper::MPGU_PP]]) ?>
    </div>

    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::MPGU_SR,
            'str' => "Абитуриенты Квотники и БВИ (всего)", 'link' => ['data-entrant/default/index', 'is_id' => JobEntrantHelper::MPGU_SR]]) ?>
        <?= CountUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::MPGU_PP,
            'str' => "Абитуриенты с ПП (всего)", 'link' => ['data-entrant/default/index', 'is_id' => JobEntrantHelper::MPGU_PP]]) ?>
    </div>
    <!--<div class="col-md-4">
        <? /*= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'list',
            'status' => StatementHelper::STATUS_WALT_SPECIAL,
            'str' => "Новые"]) */ ?>
        <? /*= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'list-ul',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые"]) */ ?>
    </div>
    <div class="col-md-4">
        <? /*= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_LIGHT_BLUE_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'list-alt',
            'status' => StatementHelper::STATUS_RECALL,
            'str' => "Отозванные ЗУК"]) */ ?>
        <? /*= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'list-ol',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые ЗУК"]) */ ?>
    </div>-->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4>Заявления об участии в конкурсе (Квота)</h4>
            </div>
            <div class="box-body">
                <?= StatementWidget::widget(['entrant' => $jobEntrant, 'category' => CategoryStruct::SPECIAL_RIGHT_COMPETITION,
                    'status' => [StatementHelper::STATUS_WALT_SPECIAL, StatementHelper::STATUS_VIEW]]) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4>Заявления об участии в конкурсе (Вне конкурса)</h4>
            </div>
            <div class="box-body">
                <?= StatementWidget::widget(['entrant' => $jobEntrant, 'category' => CategoryStruct::WITHOUT_COMPETITION,
                    'status' => [StatementHelper::STATUS_WALT_SPECIAL,  StatementHelper::STATUS_VIEW]]) ?>
            </div>
        </div>
    </div>
</div>
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
<?php Box::begin(
    [   "header" => "Отозванные заявления  об участии в конкурсе",
        "type" => Box::TYPE_INFO,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-3">
        <?= InfoFokZukRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_WALT,
            'str' => "Новые", 'link'=> ['/data-entrant/statement-rejection/new']])?>
    </div>
    <div class="col-md-3">
        <?=  InfoFokZukRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_LIGHT_BLUE,
            'entrant'=> $jobEntrant,
            'icon'=> 'circle',
            'status' => StatementHelper::STATUS_VIEW,
            'str' => "Взято в работу", 'link' => ['/data-entrant/statement-rejection/index', 'status'=> StatementHelper::STATUS_VIEW]])?>
    </div>
    <div class="col-md-3">
        <?=  InfoFokZukRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement-rejection/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-3">
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
    [   "header" => "Отозванные заявления  об участии в конкурсе (Конкурсная группа)",
        "type" => Box::TYPE_INFO,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-4">
        <?= InfoFokZukCgRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_WALT,
            'str' => "Новые", 'link'=> ['/data-entrant/statement-rejection/cg-new']])?>
    </div>
    <div class="col-md-4">
        <?=  InfoFokZukCgRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_TEAL,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement-rejection/cg-index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-4">
        <?=  InfoFokZukCgRemoveWidget::widget([
            'colorBox' => AdminLTE::BG_FUCHSIA,
            'entrant'=> $jobEntrant,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/data-entrant/statement-rejection/cg-index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
</div>

<?php Box::end() ?>

<?php Box::begin(
    [   "header" => "Заявления о согласии на зачисление",
        "type" => Box::TYPE_WARNING,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-6">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_TEAL_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_WALT,
            'str' => "Новые", 'link'=> ['/data-entrant/statement-consent-cg/new']])?>
    </div>
    <div class="col-md-6">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_LIGHT_BLUE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_VIEW,
            'str' => "Взято в работу", 'link' => ['/data-entrant/statement-consent-cg/index', 'status'=> StatementHelper::STATUS_VIEW]])?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement-consent-cg/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-4">
        <?= InfoFokZosWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/data-entrant/statement-consent-cg/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-3">
        <?= InfoFokRemoveZosWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA,
            'entrant'=> $jobEntrant,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_WALT,
            'str' => "Новые", 'link'=> ['/data-entrant/statement-rejection/consent-new']])?>
    </div>
    <div class="col-md-3">
        <?=  InfoFokRemoveZosWidget::widget([
            'colorBox' => AdminLTE::BG_LIGHT_BLUE,
            'entrant'=> $jobEntrant,
            'icon'=> 'circle',
            'status' => StatementHelper::STATUS_VIEW,
            'str' => "Взято в работу", 'link' => ['/data-entrant/statement-rejection/consent-index', 'status'=> StatementHelper::STATUS_VIEW]])?>
    </div>
    <div class="col-md-3">
        <?=  InfoFokRemoveZosWidget::widget([
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/data-entrant/statement-rejection/consent-index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-3">
        <?=  InfoFokRemoveZosWidget::widget([
            'colorBox' => AdminLTE::BG_MAROON,
            'entrant'=> $jobEntrant,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/data-entrant/statement-rejection/consent-index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
</div>
<?php Box::end() ?>


