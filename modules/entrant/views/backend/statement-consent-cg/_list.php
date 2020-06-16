<?php
/* @var $model \modules\entrant\models\StatementConsentCg */
use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

ModalAsset::register($this);
?>
<?= Html::a("Документы", ['default/files', 'user' => $model->statementCg->statement->user_id], ['class' => 'btn btn-danger']) ?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $model->statementCg->statement->user_id]) ?>
<?= \modules\entrant\widgets\statement\StatementBackendWidget::widget(['statement' => $model->statementCg->statement]) ?>
<?= \modules\entrant\widgets\statement\StatementCgBackendConsentWidget::widget(['statementId' => $model->statementCg->statement->id]) ?>
