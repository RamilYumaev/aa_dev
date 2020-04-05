<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AgreementForm */

$this->title = "Договор. Редактирование.";
$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
