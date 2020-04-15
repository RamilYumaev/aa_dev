<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model olympic\forms\OlympicCreateForm */
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-olimpic', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>

    <?= $form->field($model, 'managerId')->widget(Select2::class, [
            'data'=>\olympic\helpers\auth\ProfileHelper::getAllUserFullNameWithEmail(),
            'options'=> ['placeholder'=>'Выберите пользователя'],
            'pluginOptions' => ['allowClear' => true],
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>