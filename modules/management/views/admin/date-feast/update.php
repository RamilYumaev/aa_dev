<?php

/* @var $this yii\web\View */
/* @var $model modules\management\forms\DateFeastForm */
$this->title = "Выходные дни. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Выходные дни', 'url' => ['date-fast/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
