<?php
/* @var $model olympic\forms\auth\SchooLUserCreateForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>
      <?= $form->field($model, 'name')->textInput() ?>
      <?= $form->field($model, 'country_id')->widget(\kartik\select2\Select2::class,[
        'name' => 'filter-country_id',
        'id' => 'filter-country_id',
        'data' =>\dictionary\helpers\DictCountryHelper::countryList(),
        'options' => ['placeholder' => 'Выберите страну'],
        'pluginOptions' => ['allowClear' => true]]
        ) ?>
<?= $form->field($model, 'region_id')->widget(\kartik\select2\Select2::class,[
        'name' => 'filter-region_id',
        'id' => 'filter-region_id',
        'data' => \dictionary\helpers\DictRegionHelper::regionList(),
        'options' => ['placeholder' => 'Выберите регион'],
        'pluginOptions' => ['allowClear' => true]]
) ?>

    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>


