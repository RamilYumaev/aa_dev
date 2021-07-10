<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\widgets\cpk\CountPotentialUserCozWidget;
use modules\entrant\widgets\cpk\CountUserCozFokWidget;
use modules\entrant\widgets\cpk\CountUserCozWidget;
use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\widgets\cpk\CountUserErrorFilesCozWidget;
use modules\entrant\widgets\cpk\FileCozWidget;
use modules\entrant\widgets\file\FileWidget;

?>
<div class="row">
    <div class="col-md-3">
        <?= CountUserCozFokWidget::widget([
            'colorBox' => AdminLTE::BG_YELLOW_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты (всего)", 'link' => ['data-entrant/default/index']]) ?>
    </div>
    <div class="col-md-3">
        <?= CountUserCozFokWidget::widget([
            'type' => AisReturnDataHelper::AIS_YES,
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user-plus',
            'str' => "Абитуриенты  (Принятые)", 'link' => ['data-entrant/default/index', 'type' => AisReturnDataHelper::AIS_YES]]) ?>
    </div>
    <div class="col-md-3">
        <?= CountUserCozFokWidget::widget([
            'type' => AisReturnDataHelper::IN_WORK,
            'colorBox' => AdminLTE::BG_AQUA,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты (Взяты в работу)", 'link' => ['data-entrant/default/index', 'type' => AisReturnDataHelper::IN_WORK]]) ?>
    </div>
    <div class="col-md-3">
        <?= CountUserCozFokWidget::widget([
            'type' => AisReturnDataHelper::AIS_NO,
            'colorBox' => AdminLTE::BG_AQUA_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты (Необработанные)", 'link' => ['data-entrant/default/index', 'type' => AisReturnDataHelper::AIS_NO]]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= CountUserCozFokWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE,
            'type' => AisReturnDataHelper::IN_EPGU,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты (ЕПГУ)", 'link' => ['data-entrant/default/index', 'type' => AisReturnDataHelper::IN_EPGU]]) ?>
    </div>
    <div class="col-md-6">
        <?= CountUserCozFokWidget::widget([
            'type' => AisReturnDataHelper::IN_TIME,
            'colorBox' => AdminLTE::BG_MAROON,
            'entrant' => $jobEntrant,
            'icon' => 'user-plus',
            'str' => "Абитуриенты  (Очные)", 'link' => ['data-entrant/default/index', 'type' =>  AisReturnDataHelper::IN_TIME]]) ?>
    </div>
</div>


