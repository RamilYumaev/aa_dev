<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dictionary\forms\DictCompetitiveGroupCreateForm | dictionary\forms\DictCompetitiveGroupEditForm*/
/* @var $form yii\widgets\ActiveForm */
?>
<div>

    <?php $form = ActiveForm::begin(['id' => 'form-competitiveGroup']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'year')->dropDownList($model->yearList()) ?>

            <?= $form->field($model, 'speciality_id')->dropDownList($model->specialityNameAndCodeList(), ['prompt' => 'Выберите направление подготовки']) ?>

            <?= $form->field($model, 'specialization_id')->dropDownList($model->specializationList(), ['prompt' => 'Выберите образовательную программу']) ?>

            <?= $form->field($model, 'education_form_id')->dropDownList($model->formList()) ?>

            <?= $form->field($model, 'edu_level')->dropDownList($model->educationLevelList()) ?>

            <?= $form->field($model, 'financing_type_id')->dropDownList($model->financingTypesList()) ?>

            <?= $form->field($model, 'faculty_id')->dropDownList($model->facultyList(),
                ['prompt' => 'Выберите институт/факультет']) ?>

            <?= $form->field($model, 'cathedraList')->widget(Select2::class, [
                'data' => \modules\dictionary\helpers\DictCathedraHelper::listNames(),
                'options' => ['placeholder' => 'Выберите кафедры', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Кафедры") ?>

            <?= $form->field($model, 'success_speciality')->widget(Select2::class, [
                'data' => \dictionary\helpers\DictSpecialityHelper::specialityNameAndCodeEduLevelList(),
                'options' => ['placeholder' => 'Выберите', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>


            <?= $form->field($model, 'kcp')->textInput() ?>

            <?= $form->field($model, 'special_right_id')->dropDownList($model->specialRightList()) ?>

            <?= $form->field($model, 'competition_count')->textInput() ?>

            <?= $form->field($model, 'passing_score')->textInput() ?>

            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'is_new_program')->checkbox() ?>

            <?= $form->field($model, 'only_spo')->checkbox() ?>

            <?= $form->field($model, 'only_pay_status')->checkbox() ?>

            <?= $form->field($model, 'education_duration')->textInput() ?>

            <?= $form->field($model, 'education_year_cost')->textInput() ?>

            <?= $form->field($model, 'discount')->textInput() ?>

            <?= $form->field($model, 'enquiry_086_u_status')->checkbox() ?>

            <?= $form->field($model, 'spo_class')->textInput() ?>

            <?= $form->field($model, 'foreigner_status')->checkbox() ?>

            <?= $form->field($model, 'tpgu_status')->checkbox() ?>

            <?= $form->field($model, 'additional_set_status')->checkbox() ?>
            <?= $form->field($model, 'is_unavailable_transfer')->checkbox() ?>

            <?= $form->field($model, 'ais_id')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
