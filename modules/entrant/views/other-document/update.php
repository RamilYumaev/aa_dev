<?php

/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */

$this->title = "Прочие документы. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
