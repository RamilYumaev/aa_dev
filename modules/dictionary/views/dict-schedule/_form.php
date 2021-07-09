<?php
/* @var $model modules\dictionary\forms\DictScheduleForm */
/* @var $form yii\bootstrap\ActiveForm */

use dictionary\helpers\DictRegionHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-schedule']); ?>
        <?= $form->field($model, 'date')->widget(\kartik\date\DatePicker::class,
            ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ]]); ?>
        <?= $form->field($model, 'category')->dropDownList(\modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories()) ?>
        <?= $form->field($model, 'count')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
