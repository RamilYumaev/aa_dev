<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model olympic\models\OlympicSpecialityProfile */
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-olympic-speciality', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'olympic_speciality_id')->widget(Select2::class, [
        'data'=> \olympic\models\OlympicSpeciality::all(),
        'options'=> ['placeholder'=>'Выберите номинацию олимпиады'],
        'pluginOptions' => ['allowClear' => true],
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
