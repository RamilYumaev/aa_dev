<?php
/* @var $model \modules\entrant\models\StatementConsentCg */
use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);
?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $model->statementCg->statement->user_id]) ?>
<?= \modules\entrant\widgets\statement\StatementBackendWidget::widget(['statement' => $model->statementCg->statement]) ?>
<?= \modules\entrant\widgets\statement\StatementCgBackendConsentWidget::widget(['statementId' => $model->statementCg->statement->id]) ?>
