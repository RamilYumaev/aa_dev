<?php
/* @var $this yii\web\View */
/* @var $transfer modules\transfer\models\TransferMpgu */
/* @var $profile olympic\models\auth\Profiles */


use modules\entrant\helpers\CseViSelectHelper;
use yii\helpers\Html;
$profile = $transfer->profile;
$this->title = $profile->getFio() . '. Персональная карточка';
$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['profiles/index']];
$this->params['breadcrumbs'][] = $this->title;
$userId = $profile->user_id;
?>
<?= Html::a("Документы", ['files', 'id' => $transfer->id], ['class' => 'btn btn-danger']) ?>
<?= Html::a("Сообщить об ошибке", ['send-error', 'user' => $transfer->id], [
    'class' => 'btn btn-danger',
    'data' => ['method' => 'post', 'confirm' => "Вы уверены что хотите отправить письмо?"]]) ?>
<?= Html::a("Редактировать данные", \Yii::$app->params['staticHostInfo'] . '/switch-user/by-user-id?id=' . $userId,
    ['class' => 'btn btn-info', 'target' => '_blank']); ?>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\profile\ProfileWidget::widget(['userId' => $userId, 'view' => 'index-backend']); ?>
</div>
<?php if(!$transfer->isMpgu()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\transfer\widgets\education\DocumentEducationWidget::widget(['userId' => $userId,  'view' => "index-backend"]); ?>
    </div>
<?php else: ?>
    <div class="mt-20 table-responsive">
        <?= \modules\transfer\widgets\transfer\TransferMpsuWidget::widget(['userId' => $userId]); ?>
    </div>
<?php endif; ?>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\address\AddressWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
</div>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['userId' => $userId, 'view' => "detail-backend"]); ?>
</div>
