<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\DocumentEducationForm */


$this->title = "Результаты ЕГЭ. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
