<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictOrganizationForm */
$this->title = "Целевые организации. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Целевые организации', 'url' => ['dict-organizations/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
