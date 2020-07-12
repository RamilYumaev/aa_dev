<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictOrganizationForm */
$this->title = "Справочник председателей экзаменационных комиссий. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Справочник председателей экзаменационных комиссий', 'url' => ['dict-examiner/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
