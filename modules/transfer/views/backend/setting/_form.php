<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use modules\transfer\models\TransferSetting;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $model TransferSetting */
/** @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'finances')->widget(\kartik\select2\Select2::class, [
    'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
    'pluginOptions' => ['allowClear' => true],
    'data' => DictCompetitiveGroupHelper::getFinancingTypes()
]) ?>


<?= $form->field($model, 'citizenship')->widget(\kartik\select2\Select2::class, [
    'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
    'pluginOptions' => ['allowClear' => true],
    'data' => DictCountryHelper::countryList()
]) ?>

<?= $form->field($model, 'semesters')->textarea([
    'rows' => 5,
    'placeholder' => '["1", "2", "3"]',
]) ?>


<?= $form->field($model, 'date_start')->widget(\kartik\datetime\DateTimePicker::class,
    ['pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii:00'
    ]]); ?>

<?= $form->field($model, 'date_end')->widget(\kartik\datetime\DateTimePicker::class,
    ['pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii:00'
    ]]); ?>

<div class="form-group">
    <?= Html::submitButton(
        $model->isNewRecord ? 'Создать' : 'Сохранить',
        ['class' => 'btn btn-success']
    ) ?>
</div>

<?php ActiveForm::end(); ?>
