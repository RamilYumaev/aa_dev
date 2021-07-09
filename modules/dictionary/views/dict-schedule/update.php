<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictScheduleForm */
$this->title = "Справочник графиков работы волонтеров. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Справочник графиков работы волонтеров', 'url' => ['dict-schedule/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
