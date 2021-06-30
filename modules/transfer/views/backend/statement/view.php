<?php

/* @var $this yii\web\View */
/* @var $statement \modules\transfer\models\StatementTransfer */
use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

ModalAsset::register($this);

$this->title = $statement->profileUser->fio .' Заявление';
$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Заявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::a("Документы", ['profiles/files', 'id' => $statement->transferMpgu->id], ['class' => 'btn btn-danger']) ?>
<?= Html::a("Сообщить об ошибке", ['profiles/send-error', 'user' =>  $statement->transferMpgu->id], [
    'class' => 'btn btn-danger',
    'data' => ['method'=>'post', 'confirm'=> "Вы уверены что хотите отправить письмо?"]]) ?>
<?php if(!$statement->transferMpgu->isMpgu()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\transfer\widgets\education\DocumentEducationWidget::widget(['userId' =>  $statement->user_id,  'view' => "index-backend"]); ?>
    </div>
<?php else: ?>
    <div class="mt-20 table-responsive">
        <?= \modules\transfer\widgets\transfer\TransferMpsuWidget::widget(['userId' =>  $statement->user_id]); ?>
    </div>
<?php endif; ?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $statement->user_id]) ?>
<?= \modules\transfer\widgets\transfer\TransferWidget::widget(['userId' => $statement->user_id, 'view' =>'index-backend', ]) ?>
<?= \modules\transfer\widgets\transfer\TransferWidget::widget(['userId' => $statement->user_id, 'view' =>'index-backend', ]) ?>
<?= \modules\transfer\widgets\generate\BackendPacketWidget::widget(['userId' => $statement->user_id]) ?>
