<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictPostEducationForm */
$this->title = "Регионы. Редактирование.";
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['dict-region/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
