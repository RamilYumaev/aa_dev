<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\CategoryStruct;
use modules\entrant\widgets\cpk\CountUserCozWidget;
use modules\entrant\widgets\cpk\InfoUserCozWidget;
use modules\entrant\widgets\cpk\StatementWidget;
use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\helpers\StatementHelper;

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
            'icon'=> 'list',
            'status' => StatementHelper::STATUS_WALT_SPECIAL,
            'str' => "Новые ЗУК"])?>
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-ul',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые ЗУК"])?>
    </div>
    <div class="col-md-4">
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_LIGHT_BLUE_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-alt',
            'status' => StatementHelper::STATUS_RECALL,
            'str' => "Отозванные ЗУК"])?>
        <?= InfoUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-ol',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые ЗУК"])?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h4>Заявления об участии в конкурсе (Квота)</h4>
            </div>
            <div class="box-body">
            <?= StatementWidget::widget(['entrant'=> $jobEntrant, 'category'=> CategoryStruct::SPECIAL_RIGHT_COMPETITION,
             'status' => StatementHelper::STATUS_WALT_SPECIAL])?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h4>Заявления об участии в конкурсе (Вне конкурса)</h4>
            </div>
            <div class="box-body">
                <?= StatementWidget::widget(['entrant'=> $jobEntrant, 'category'=> CategoryStruct::WITHOUT_COMPETITION,
                    'status' => StatementHelper::STATUS_WALT_SPECIAL])?>
            </div>
        </div>
    </div>
</div>


