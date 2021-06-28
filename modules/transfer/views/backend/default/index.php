<?php
/* @var $this yii\web\View */

$this->title = 'Перевод и восстановление';
$this->params['breadcrumbs'][] = $this->title;

use backend\widgets\adminlte\components\AdminLTE;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\widgets\info\InfoUserFullWidget;
use modules\transfer\widgets\info\StatusStatementCountWidget;
use modules\transfer\models\TransferMpgu;
use yiister\adminlte\widgets\Box;

$types = (new TransferMpgu())->listTypeShort();
?>

<div class="box">
    <div class="box-body box-primary">
        <div class="row">
            <div class="col-md-12">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_BLUE,
                    'icon'=> 'users',
                    'str' => 'Всего',
                    'link' => ['profiles/index']])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_TEAL,
                    'icon'=> 'user',
                    'type' => TransferMpgu::IN_MPGU,
                    'str' => $types[TransferMpgu::IN_MPGU],
                    'link' => ['profiles/index', 'type' => TransferMpgu::IN_MPGU]
                    ])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_ORANGE,
                    'icon'=> 'user',
                    'type' => TransferMpgu::IN_INSIDE_MPGU,
                    'str' => $types[TransferMpgu::IN_INSIDE_MPGU],
                    'link' => ['profiles/index', 'type' => TransferMpgu::IN_INSIDE_MPGU]
                ])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_FUCHSIA,
                    'icon'=> 'user',
                    'type' => TransferMpgu::INSIDE_MPGU,
                    'str' => $types[TransferMpgu::INSIDE_MPGU],
                    'link' => ['profiles/index', 'type' => TransferMpgu::INSIDE_MPGU]
                ])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE_ACTIVE,
                    'icon'=> 'user',
                    'type' => TransferMpgu::FROM_EDU,
                    'str' => $types[TransferMpgu::FROM_EDU],
                    'link' => ['profiles/index', 'type' => TransferMpgu::FROM_EDU]])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4>Заявления (Новые)</h4>
            </div>
            <div class="box-body">
                <?= \modules\transfer\widgets\transfer\TransferBackendWidget::widget() ?>
            </div>
        </div>
    </div>
</div>
<?php Box::begin(
    [   "header" => "Заявления",
        "type" => Box::TYPE_SUCCESS,
        "collapsable" => true,]) ?>
<div class="row">
    <div class="col-md-6">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_YELLOW,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_DRAFT,
            'str' => "Неотправленные", 'link'=> ['statement/index', 'status'=> StatementHelper::STATUS_DRAFT]])?>
    </div>
    <div class="col-md-6">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_TEAL_ACTIVE,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_WALT,
            'str' => "Новые", 'link'=> ['statement/index', 'status'=> StatementHelper::STATUS_WALT]])?>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
    <?= StatusStatementCountWidget::widget([
        'colorBox' => AdminLTE::BG_LIGHT_BLUE,
        'icon'=> 'circle',
        'status' => StatementHelper::STATUS_VIEW,
        'str' => "Взято в работу", 'link' => ['statement/index', 'status'=> StatementHelper::STATUS_VIEW]])?>
    </div>
    <div class="col-md-4">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['statement/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-4">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['statement/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
</div>
<?php Box::end() ?>

