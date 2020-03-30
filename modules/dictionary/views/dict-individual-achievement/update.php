<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictIndividualAchievementForm */
$this->title = "Индивидуальные достижения. Редактирование.";
$this->params['breadcrumbs'][] = ['label' => 'Индивидуальные достижения', 'url' => ['dict-individual-achievement/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
