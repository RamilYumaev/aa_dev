<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictOrganizationForm */
$this->title = "'Справочник администраторов центров. Редактировние.";
$this->params['breadcrumbs'][] = ['label' => 'Справочник администраторов центров', 'url' => ['admin-center/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
