<?php

/* @var $this yii\web\View */
/* @var $statement \modules\entrant\models\StatementIndividualAchievements */

$this->title = $statement->profileUser->fio .' '. $statement->numberStatement;
$this->params['breadcrumbs'][] = ['label' => 'Заявления об учете индивидуальных достижений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

ModalAsset::register($this);


?>
<?= Html::a("Документы", ['default/files', 'user' => $statement->user_id], ['class' => 'btn btn-danger']) ?>
<?= Html::a("Сообщить об ошибке", ['default/send-error', 'user' =>  $statement->user_id], [
    'class' => 'btn btn-danger',
    'data' => ['method'=>'post', 'confirm'=> "Вы уверены что хотите отправить письмо?"]]) ?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\anketa\AnketaWidget::widget(['userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\statement\StatementIaBackendWidget::widget(['statement' => $statement]) ?>
