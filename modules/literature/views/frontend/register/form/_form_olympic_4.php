<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model modules\literature\models\LiteratureOlympic */

use kartik\date\DatePicker;
use kartik\file\FileInput;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
<div class="col-md-6">
    <?= $form->field($model, 'date_arrival')->widget(\kartik\datetime\DateTimePicker::class,
        ['pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:00'
        ]]); ?>
    <?= $form->field($model, 'type_transport_arrival')->dropDownList($model->getTransports()) ?>
    <?= $form->field($model, 'place_arrival')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'number_arrival')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-md-6">
    <?= $form->field($model, 'date_departure')->widget(\kartik\datetime\DateTimePicker::class,
        ['pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:00'
        ]]); ?>
    <?= $form->field($model, 'type_transport_departure')->dropDownList($model->getTransports()) ?>
    <?= $form->field($model, 'place_departure')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'number_departure')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-md-12">
    <div class="form-group">
        <?= Html::submitButton('Далее', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>






