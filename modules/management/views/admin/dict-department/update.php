<?php

/* @var $this yii\web\View */
/* @var $model modules\management\forms\DictTaskForm */
$this->title = "Отделы УОПП. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Отделы УОПП', 'url' => ['dict-department/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
