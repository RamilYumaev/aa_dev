<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use backend\widgets\adminlte\Box;
use modules\entrant\widgets\cpk\InfoUserExamCozWidget;
use backend\widgets\adminlte\components\AdminLTE;
?>
<?php Box::begin(
    [   "header" => "Заявления об участии в конкурсе (ВИ)",
        "type" => Box::TYPE_SUCCESS,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-6">
        <?= InfoUserExamCozWidget::widget([
            'colorBox' => AdminLTE::BG_AQUA,
            'entrant'=> $jobEntrant,
            'icon'=> 'list-alt',
            'exam' => 'vi',
            'str' => "ЗУК (ВИ)", 'link'=> ['data-entrant/statement-exam/index', 'exam' => 'vi']])?>
    </div>
    <div class="col-md-6">
        <?= InfoUserExamCozWidget::widget([
            'colorBox' => AdminLTE::BG_NAVY_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'list',
            'exam' => 'vi-as-cse',
            'str' => "ЗУК (ВИ-ЕГЭ)", 'link' => ['data-entrant/statement-exam/index', 'exam' => 'vi-aa-cse']])?>
    </div>
</div>
<?php Box::end() ?>

