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
    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_YELLOW_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты (всего)", 'link' => ['data-entrant/default/index']]) ?>
    </div>
    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'type' => 1,
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user-plus',
            'str' => "Абитуриенты  (Принятые)", 'link' => ['data-entrant/default/index', 'type' => AisReturnDataHelper::AIS_YES]]) ?>
    </div>
    <div class="col-md-4">
        <?= CountUserCozFokWidget::widget([
            'type' => 3,
            'colorBox' => AdminLTE::BG_AQUA,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты (Взяты в работу)", 'link' => ['data-entrant/default/index', 'type' => 3]]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'type' => 2,
            'colorBox' => AdminLTE::BG_AQUA_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты (Не обработанные)", 'link' => ['data-entrant/default/index', 'type' => AisReturnDataHelper::AIS_NO]]) ?>
    </div>
    <div class="col-md-4">
        <?= CountUserErrorFilesCozWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Абитуриенты c откл. файлами", 'link' => ['data-entrant/default/index-file']]) ?>
    </div>
    <div class="col-md-4">
        <?=  CountPotentialUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_MAROON,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'str' => "Потенциальные абитуриенты", 'link' => ['data-entrant/entrant-potential/index']]) ?>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4> Загруженные(обновленные) файлы</h4>
            </div>
            <div class="box-body">
                <?= FileCozWidget::widget(['entrant'=> $jobEntrant])?>
            </div>
        </div>
    </div>

</div>