<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $specialization dictionary\models\DictSpecialization */
/* @var $model dictionary\forms\DictSpecializationEditForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ' . $specialization->name;
$this->params['breadcrumbs'][] = ['label' => 'Образовательные программы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-specialization']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'speciality_id')->dropDownList($model->specialityNameAndCodeList(), ["prompt" => "Выберите направление подготовки"]) ?>
            <?= $form->field($model, 'ais_id')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
