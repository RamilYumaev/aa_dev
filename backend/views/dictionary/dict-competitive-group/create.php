<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dictionary\forms\DictCompetitiveGroupCreateForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <?php $form = ActiveForm::begin(['id' => 'form-competitiveGroup']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'year')->dropDownList($model->yearList()) ?>

            <?= $form->field($model, 'speciality_id')->dropDownList($model->specialityNameAndCodeList(), ['prompt' => 'Выберите направление подготовки']) ?>

            <?= $form->field($model, 'specialization_id')->dropDownList($model->specializationList(), ['prompt' => 'Выберите образовательную программу']) ?>

            <?= $form->field($model, 'education_form_id')->dropDownList($model->formList()) ?>

            <?= $form->field($model, 'financing_type_id')->dropDownList($model->financingTypesList()) ?>

            <?= $form->field($model, 'faculty_id')->dropDownList($model->facultyList(), ['prompt' => 'Выберите институт/факультет']) ?>

            <?= $form->field($model, 'kcp')->textInput() ?>

            <?= $form->field($model, 'special_right_id')->dropDownList($model->specialRightList()) ?>

            <?= $form->field($model, 'competition_count')->textInput() ?>

            <?= $form->field($model, 'passing_score')->textInput() ?>

            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'is_new_program')->checkbox() ?>

            <?= $form->field($model, 'only_pay_status')->checkbox() ?>

            <?= $form->field($model, 'education_duration')->textInput() ?>

            <?= $form->field($model, 'education_year_cost')->textInput() ?>

            <?= $form->field($model, 'discount')->textInput() ?>

            <?= $form->field($model, 'enquiry_086_u_status')->checkbox() ?>

            <?= $form->field($model, 'spo_class')->textInput() ?>

            <?= $form->field($model, 'ais_id')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
