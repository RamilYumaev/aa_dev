<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\CategoryStruct;
use modules\entrant\widgets\cpk\CountUserCozWidget;
use modules\entrant\widgets\cpk\FileCozWidget;
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
            'isID' => JobEntrantHelper::TASHKENT_BB,
            'str' => "Абитуриенты Ташкентского договора (новые)", 'link' => ['data-entrant/default/index', 'type' => 2, 'is_id' => JobEntrantHelper::TASHKENT_BB]]) ?>
        <?= CountUserCozWidget::widget([
            'type' => 2,
            'colorBox' => AdminLTE::BG_BLUE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::TARGET_BB,
            'str' => "Абитуриенты Целевики и Соотечественники (новые)", 'link' => ['data-entrant/default/index', 'type' => 2, 'is_id' => JobEntrantHelper::TARGET_BB]]) ?>

        <?= CountUserCozWidget::widget([
            'type' => 2,
            'colorBox' => AdminLTE::BG_BLUE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::SPECIAL_QUOTA,
            'str' => "Абитуриенты СпецКвоты (новые)", 'link' => ['data-entrant/default/index', 'type' => 2, 'is_id' => JobEntrantHelper::SPECIAL_QUOTA]]) ?>
    </div>

    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'type' => 1,
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::TASHKENT_BB,
            'str' => "Абитуриенты Ташкентского договора (принятые)", 'link' => ['data-entrant/default/index', 'type' => 1, 'is_id' => JobEntrantHelper::TASHKENT_BB]]) ?>
        <?= CountUserCozWidget::widget([
            'type' => 1,
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::TARGET_BB,
            'str' => "Абитуриенты Целевики и Соотечественники (принятые)", 'link' => ['data-entrant/default/index', 'type' => 1, 'is_id' => JobEntrantHelper::TARGET_BB]]) ?>

        <?= CountUserCozWidget::widget([
            'type' => 1,
            'colorBox' => AdminLTE::BG_OLIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::SPECIAL_QUOTA,
            'str' => "Абитуриенты СпецКвоты", 'link' => ['data-entrant/default/index', 'type' => 1, 'is_id' => JobEntrantHelper::SPECIAL_QUOTA]]) ?>
    </div>

    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::TASHKENT_BB,
            'str' => "Абитуриенты Ташкентского договора  (всего)", 'link' => ['data-entrant/default/index', 'is_id' => JobEntrantHelper::TASHKENT_BB]]) ?>
        <?= CountUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::TARGET_BB,
            'str' => "Абитуриенты Целевики и Соотечественники (всего)", 'link' => ['data-entrant/default/index', 'is_id' => JobEntrantHelper::TARGET_BB]]) ?>
        <?= CountUserCozWidget::widget([
            'colorBox' => AdminLTE::BG_ORANGE_ACTIVE,
            'entrant' => $jobEntrant,
            'icon' => 'user',
            'isID' => JobEntrantHelper::SPECIAL_QUOTA,
            'str' => "Абитуриенты СпецКвоты", 'link' => ['data-entrant/default/index', 'is_id' => JobEntrantHelper::SPECIAL_QUOTA]]) ?>
    </div>
</div>



