<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictCseSubjectForm */
$this->title = "Предметы ЦТ. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Предметы ЦТ', 'url' => ['dict-cse-subject/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
