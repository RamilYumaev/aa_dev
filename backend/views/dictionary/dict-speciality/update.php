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
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-speciality']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
