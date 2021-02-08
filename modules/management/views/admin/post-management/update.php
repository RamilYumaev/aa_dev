<?php

/* @var $this yii\web\View */
/* @var $model modules\management\forms\PostManagementForm */
$this->title = "Справочник должностей. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Справочник должностей', 'url' => ['post-management/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
