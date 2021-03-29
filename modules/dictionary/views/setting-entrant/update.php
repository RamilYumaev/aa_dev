<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\SettingEntrantForm */
$this->title = "Настройки приема. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Настройки приема', 'url' => ['setting-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
