<?php

/* @var $this yii\web\View */
/* @var $statement \modules\entrant\models\Statement */
use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

$this->title = $statement->profileUser->fio .' '. $statement->numberStatement;
$this->params['breadcrumbs'][] = ['label' => 'Заявления об участии в конкурсе', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\anketa\AnketaWidget::widget(['userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\statement\StatementBackendWidget::widget(['statement' => $statement]) ?>
<?= \modules\entrant\widgets\statement\StatementCgBackendConsentWidget::widget(['statementId' => $statement->id]) ?>
