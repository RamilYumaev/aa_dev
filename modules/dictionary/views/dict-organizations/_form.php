<?php
/* @var $model modules\dictionary\forms\DictOrganizationForm */
/* @var $form yii\bootstrap\ActiveForm */

use dictionary\helpers\DictRegionHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-organization']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'kpp')->widget(MaskedInput::class, [
            'mask' => '999999999',
        ]) ?>
        <?= $form->field($model, 'ogrn')->widget(MaskedInput::class, [
            'mask' => '9999999999999',
        ]) ?>
        <?= $form->field($model, 'region_id')->dropDownList(DictRegionHelper::regionList()) ?>
        <?php if($model->entrant): ?>
        <?= $form->field($model, 'type')->dropDownList($model->typeList())->label('Тип') ?>
        <?php endif; ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
