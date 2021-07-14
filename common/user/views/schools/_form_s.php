<?php
/* @var $model \common\user\form\SchoolAndClassForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-school-user']); ?>
<?php if ($model->getScenario() ==  \common\user\form\SchoolAndClassForm::UPDATE_CREATE) : ?>
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
        'pluginOptions' => ['allowClear' => true]]
) ?>
<?php endif; ?>
<?= $form->field($model, 'class_id')->dropDownList(\dictionary\helpers\DictClassHelper::getList()) ?>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php
$this->registerJS(<<<JS
        var typeSelect = $("#schoolandclassform-country_id");
        var region = $("#schoolandclassform-region_id");
        $(typeSelect).on("change init", function() {
if(this.value == 46){
region.attr('disabled', false);
}else {
region.attr('disabled', true).select('');
}
}).trigger("init");
JS
);
