<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictForeignLanguageForm */
$this->title = "Кафедра. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Кафедры', 'url' => ['dict-cathedra/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
