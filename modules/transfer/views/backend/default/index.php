<?php
/* @var $this yii\web\View */
/* @var  $jobEntrant JobEntrant*/
$jobEntrant = \Yii::$app->user->identity->jobEntrant();
if($jobEntrant->isAgreement()) {
    $this->title = 'Перевод и восстановление';
    $this->params['breadcrumbs'][] = $this->title;
}
use backend\widgets\adminlte\components\AdminLTE;
use modules\dictionary\models\JobEntrant;use modules\entrant\helpers\StatementHelper;
use modules\transfer\models\PassExam;
use modules\transfer\widgets\info\ExamPassCountWidget;
use modules\transfer\widgets\info\ExamSuccessCountWidget;
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
                    'link' => ['/transfer/profiles/index']])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_TEAL,
                    'icon'=> 'user',
                    'type' => TransferMpgu::IN_MPGU,
                    'str' => $types[TransferMpgu::IN_MPGU],
                    'link' => ['/transfer/profiles/index', 'type' => TransferMpgu::IN_MPGU]
                    ])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_ORANGE,
                    'icon'=> 'user',
                    'type' => TransferMpgu::IN_INSIDE_MPGU,
                    'str' => $types[TransferMpgu::IN_INSIDE_MPGU],
                    'link' => ['/transfer/profiles/index', 'type' => TransferMpgu::IN_INSIDE_MPGU]
                ])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_GREEN,
                    'icon'=> 'user',
                    'type' => TransferMpgu::IN_MPGU_GIA,
                    'str' => $types[TransferMpgu::IN_MPGU_GIA],
                    'link' => ['/transfer/profiles/index', 'type' => TransferMpgu::IN_MPGU_GIA]
                ])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_FUCHSIA,
                    'icon'=> 'user',
                    'type' => TransferMpgu::INSIDE_MPGU,
                    'str' => $types[TransferMpgu::INSIDE_MPGU],
                    'link' => ['/transfer/profiles/index', 'type' => TransferMpgu::INSIDE_MPGU]
                ])
                ?>
            </div>
            <div class="col-md-6">
                <?= InfoUserFullWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE_ACTIVE,
                    'icon'=> 'user',
                    'type' => TransferMpgu::FROM_EDU,
                    'str' => $types[TransferMpgu::FROM_EDU],
                    'link' => ['/transfer/profiles/index', 'type' => TransferMpgu::FROM_EDU]])
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
<?php if($jobEntrant->isTransferFok()) : ?>
    <div class="row">
        <div class="col-md-12">
            <?= StatusStatementCountWidget::widget([
                'colorBox' => AdminLTE::BG_YELLOW,
                'icon'=> 'plus-circle',
                'status' => StatementHelper::STATUS_ACCEPTED,
                'str' => "Новые", 'link'=> ['/transfer/statement/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
        </div>
    </div>
<?php else: ?>
<div class="row">
    <div class="col-md-6">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_YELLOW,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_DRAFT,
            'str' => "Неотправленные", 'link'=> ['/transfer/statement/index', 'status'=> StatementHelper::STATUS_DRAFT]])?>
    </div>
    <div class="col-md-6">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_TEAL_ACTIVE,
            'icon'=> 'plus-circle',
            'status' => StatementHelper::STATUS_WALT,
            'str' => "Новые", 'link'=> ['/transfer/statement/index', 'status'=> StatementHelper::STATUS_WALT]])?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
    <?= StatusStatementCountWidget::widget([
        'colorBox' => AdminLTE::BG_LIGHT_BLUE,
        'icon'=> 'circle',
        'status' => StatementHelper::STATUS_VIEW,
        'str' => "Взято в работу", 'link' => ['/transfer/statement/index', 'status'=> StatementHelper::STATUS_VIEW]])?>
    </div>
    <div class="col-md-4">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN_ACTIVE,
            'icon'=> 'check-circle',
            'status' => StatementHelper::STATUS_ACCEPTED,
            'str' => "Принятые", 'link' => ['/transfer/statement/index', 'status'=> StatementHelper::STATUS_ACCEPTED]])?>
    </div>
    <div class="col-md-4">
        <?= StatusStatementCountWidget::widget([
            'colorBox' => AdminLTE::BG_RED_ACTIVE,
            'icon'=> 'remove',
            'status' => StatementHelper::STATUS_NO_ACCEPTED,
            'str' => "Непринятые", 'link' => ['/transfer/statement/index', 'status'=> StatementHelper::STATUS_NO_ACCEPTED]])?>
    </div>
</div>
    <div class="row">
        <div class="col-md-6">
            <?= ExamPassCountWidget::widget([
                'colorBox' => AdminLTE::BG_BLUE,
                'icon'=> 'list',
                'protocol' => true,
                'str' => "Внесены в протокол", 'link'=> ['/transfer/pass-exam/index', 'protocol'=> true]])?>
        </div>
        <div class="col-md-6">
            <?= ExamPassCountWidget::widget([
                'colorBox' => AdminLTE::BG_RED_ACTIVE,
                'icon'=> 'list',
                'protocol' => false,
                'str' => "Не внесены в протокол", 'link'=> ['/transfer/pass-exam/index', 'protocol'=> false]])?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3> Аттестационные испытания</h3>
        </div>
        <div class="col-md-4">
            <?= ExamSuccessCountWidget::widget([
                'colorBox' => AdminLTE::BG_YELLOW,
                'icon'=> 'list',
                'exam' => 0,
                'str' => "Нет данных", 'link'=> ['/transfer/pass-exam/exam', 'exam'=> 0]])?>
        </div>
        <div class="col-md-4">
            <?= ExamSuccessCountWidget::widget([
                'colorBox' => AdminLTE::BG_GREEN,
                'icon'=> 'list',
                'exam' => 1,
                'str' => "Успешно", 'link'=> ['/transfer/pass-exam/exam', 'exam'=> 1]])?>
        </div>
        <div class="col-md-4">
            <?= ExamSuccessCountWidget::widget([
                'colorBox' => AdminLTE::BG_RED_ACTIVE,
                'icon'=> 'list',
                'exam' => 2,
                'str' => "Неуспешно", 'link'=> ['/transfer/pass-exam/exam', 'exam'=> 2]])?>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-6">
        <?= ExamPassCountWidget::widget([
            'colorBox' => AdminLTE::BG_GREEN,
            'icon'=> 'plus-circle',
            'status' => PassExam::SUCCESS,
            'str' => "Допущенные", 'link'=> ['/transfer/pass-exam/index', 'status'=>  PassExam::SUCCESS]])?>
    </div>
    <div class="col-md-6">
        <?= ExamPassCountWidget::widget([
            'colorBox' => AdminLTE::BG_RED,
            'icon'=> 'minus-circle',
            'status' => PassExam::DANGER,
            'str' => "Недопущенные", 'link'=> ['/transfer/pass-exam/index', 'status'=>  PassExam::DANGER]])?>
    </div>
</div>
<?php Box::end() ?>

