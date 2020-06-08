<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\widgets\cpk\CountUserCozWidget;
use modules\entrant\widgets\cpk\InfoUserCozWidget;
use modules\entrant\widgets\cpk\StatementWidget;
use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\helpers\StatementHelper;
$new = $jobEntrant->isCategoryTarget() ? StatementHelper::STATUS_WALT_SPECIAL : StatementHelper::STATUS_WALT;
?>
<div class="row">
    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'user',
            'str' => "Абитуриенты", 'link'=> ['data-entrant/default/index']  ])?>
    </div>
    <div class="col-md-4">
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-ul',
            'status' => $new,
            'str' => "Новые"])?>
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-ul',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые"])?>
    </div>
    <div class="col-md-4">
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_LIGHT_BLUE_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-ul',
            'status' => StatementHelper::STATUS_RECALL,
            'str' => "Отозванные"])?>
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-ul',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые"])?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4>Заявления об участии в конкурсе</h4>
            </div>
            <div class="box-body">
            <?= StatementWidget::widget(['entrant'=> $jobEntrant, 'status' => $new])?>
            </div>
        </div>
    </div>
</div>


