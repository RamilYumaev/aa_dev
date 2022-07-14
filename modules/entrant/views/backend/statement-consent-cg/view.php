<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\models\StatementConsentCg */
/* @var $statement \modules\entrant\models\Statement */
use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

ModalAsset::register($this);

$statement = $model->statementCg->statement;
$this->title = $statement->profileUser->fio .' '.$model->statementCg->cg->fullNameB;
$this->params['breadcrumbs'][] = ['label' => 'Заявление о согласии на зачисление', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::a("Документы", ['default/files', 'user' => $statement->user_id], ['class' => 'btn btn-danger']) ?>
<?= Html::a("Сообщить об ошибке", ['default/send-error', 'user' =>  $statement->user_id], [
    'class' => 'btn btn-danger',
    'data' => ['method'=>'post', 'confirm'=> "Вы уверены что хотите отправить письмо?"]]) ?>
<?= \modules\entrant\widgets\profile\ProfileWidget::widget([ 'view' =>'index-backend', 'userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\anketa\AnketaWidget::widget(['userId' => $statement->user_id]) ?>
<?= \modules\entrant\widgets\statement\StatementCgBackendConsentWidget::widget(['statementId' => $statement->id]) ?>
<?= \modules\entrant\widgets\statement\StatementBackendWidget::widget(['statement' => $statement]) ?>

