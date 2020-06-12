<?php

/* @var $this yii\web\View */
/* @var $statement \modules\entrant\models\StatementIndividualAchievements */

$this->title = $statement->profileUser->fio .' '. $statement->numberStatement;
$this->params['breadcrumbs'][] = ['label' => 'Заявления об учете индивидуальных достижений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);


?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\anketa\AnketaWidget::widget(['userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\statement\StatementIaBackendWidget::widget(['statement' => $statement]) ?>
