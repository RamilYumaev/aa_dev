<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictForeignLanguageForm */
$this->title = "Иностранные языки. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Иностранные языки', 'url' => ['dict-foreign-language/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
