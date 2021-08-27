<?php

/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\EventForm */
$this->title = "Собрание первокурсников. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Собрание первокурсников', 'url' => ['event/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
