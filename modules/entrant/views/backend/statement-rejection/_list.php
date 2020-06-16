<?php
/* @var $model \modules\entrant\models\Statement */
use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);
use yii\helpers\Html;
?>
<?= Html::a("Документы", ['default/files', 'user' => $model->user_id], ['class' => 'btn btn-danger']) ?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $model->user_id]) ?>
<?= \modules\entrant\widgets\anketa\AnketaWidget::widget(['userId' => $model->user_id]) ?>
<?= \modules\entrant\widgets\statement\StatementBackendWidget::widget(['statement' => $model]) ?>