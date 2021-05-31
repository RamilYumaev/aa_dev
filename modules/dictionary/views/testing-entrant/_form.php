<?php
/* @var $model modules\dictionary\forms\TestingEntrantForm */
/* @var $form yii\bootstrap\ActiveForm */

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use modules\dictionary\models\DictTestingEntrant;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'department')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => \dictionary\helpers\DictFacultyHelper::facultyListSetting()
        ]) ?>
        <?= $form->field($model, 'special_right')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => false],
            'data' => \dictionary\helpers\DictCompetitiveGroupHelper::getSpecialRightTesting()
        ]) ?>
        <?= $form->field($model, 'edu_level')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => \dictionary\helpers\DictCompetitiveGroupHelper::getEduLevelsAbbreviated()
        ]) ?>
        <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'country')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...',],
            'pluginOptions' => ['allowClear' => true],
            'data' => \dictionary\helpers\DictCountryHelper::countryList()
        ]) ?>
        <?= $form->field($model, 'category')->dropDownList(\modules\entrant\helpers\CategoryStruct::labelLists(), ['prompt'=> 'Выберите']) ?>
        <?= $form->field($model, 'edu_document')->dropDownList(\modules\entrant\helpers\AnketaHelper::currentEducationLevel(), ['prompt'=> 'Выберите']) ?>
        <?= $form->field($model, 'user_id')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...',],
            'pluginOptions' => ['allowClear' => true],
            'data' => \olympic\helpers\auth\ProfileHelper::getVolunteering()
        ]) ?>
        <?= $this->render('_task', ['model'=> $model, 'form'=> $form]) ?>
        <?= $form->field($model, 'note')->widget(CKEditor::class, [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
        ]); ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
