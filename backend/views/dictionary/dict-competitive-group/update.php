<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $competitiveGroup dictionary\models\DictCompetitiveGroup */
/* @var $model dictionary\forms\DictCompetitiveGroupEditForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ';
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-competitiveGroup']); ?>
    <div class="box box-default">
        <div class="box-body">

            <?= $form->field($model, 'speciality_id')->dropDownList($model->specialityNameAndCodeList(),['prompt'=> 'Выберите направление подготовки']) ?>

            <?= $form->field($model, 'specialization_id')->dropDownList($model->specializationList(), ['prompt'=> 'Выберите образовательную программу']) ?>

            <?= $form->field($model, 'edu_level')->dropDownList($model->eduLevelsList()) ?>

            <?= $form->field($model, 'education_form_id')->dropDownList($model->formList()) ?>

            <?= $form->field($model, 'financing_type_id')->dropDownList($model->financingTypesList()) ?>

            <?= $form->field($model, 'faculty_id')->dropDownList($model->facultyList(), ['prompt'=> 'Выберите институт/факультет']) ?>

            <?= $form->field($model, 'kcp')->textInput() ?>

            <?= $form->field($model, 'special_right_id')->dropDownList($model->specialRightList()) ?>

            <?= $form->field($model, 'competition_count')->textInput() ?>

            <?= $form->field($model, 'passing_score')->textInput() ?>

            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'is_new_program')->checkbox() ?>

            <?= $form->field($model, 'only_pay_status')->checkbox() ?>

            <?= $form->field($model, 'education_duration')->textInput() ?>
        </div>
    </div>
    <div>
        <?= \backend\widgets\dictionary\DisciplineComplectiveWidget::widget(['competitive_group_id'=> $competitiveGroup->id]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

