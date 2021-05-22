<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $speciality dictionary\models\DictSpeciality */
/* @var $model dictionary\forms\DictSpecialityEditForm*/
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ' . $speciality->name;
$this->params['breadcrumbs'][] = ['label' => 'Направления подготовки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<?= $this->render('_form',['model'=> $model]); ?>