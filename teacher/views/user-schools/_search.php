<?php

/* @var $this yii\web\View */

/* @var $model teacher\models\searches\UserOlympicSearch */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>
    <?= $form->field($model, 'school_id')->dropDownList($model->listSchool()) ?>
    <?= $form->field($model, 'olympiads_id')->dropDownList($model->listOlympic()) ?>
    <?= Html::submitButton('Найти', ['class' => 'clearfix btn btn-success', "style"=>"width:100%"]) ?>
<?php ActiveForm::end(); ?>

