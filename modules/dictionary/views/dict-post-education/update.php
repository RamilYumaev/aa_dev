<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictPostEducationForm */
$this->title = "Должности. Редактирование.";
$this->params['breadcrumbs'][] = ['label' => 'Должности', 'url' => ['dict-post-education/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
