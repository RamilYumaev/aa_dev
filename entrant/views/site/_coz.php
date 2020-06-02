<?php
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\widgets\cpk\CountUserCozWidget;
use backend\widgets\adminlte\components\AdminLTE;
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
    <?= CountUserCozWidget::widget([
            'type' =>1,
        'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
        'entrant'=> $jobEntrant,
        'icon'=> 'user-plus',
        'str' => "Абитуриенты  (Принятые)", 'link'=> ['data-entrant/default/index', 'type' => AisReturnDataHelper::AIS_YES ] ])?>
    </div>
    <div class="col-md-4">
        <?= CountUserCozWidget::widget([
            'type' =>2,
            'colorBox' => AdminLTE::BG_YELLOW_ACTIVE,
            'entrant'=> $jobEntrant,
            'icon'=> 'user',
            'str' => "Абитуриенты (Неприянтые)", 'link'=> ['data-entrant/default/index', 'type' => AisReturnDataHelper::AIS_NO ]  ])?>
    </div>
</div>

