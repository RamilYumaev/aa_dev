<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\JobEntrantForm */
$this->title = "Центр приемной комиссии. Сотрудники. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Центр приемной комиссии. Сотрудники', 'url' => ['job-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
