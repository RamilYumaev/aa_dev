<?php


use yii\widgets\ActiveForm;
use \olympic\helpers\auth\ProfileHelper;
use yii\helpers\Html;
use kartik\select2\Select2;
use \common\auth\models\SwitchUser;
use \dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;

$this->title = "Форма переключения на другого пользователя";
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="container mt-50">
        <h1><?= $this->title ?></h1>
        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(['id' => 'form-switch-user', 'options' => ['autocomplete' => 'off']]); ?>
                <?= $form->field($model, 'submittedStatus')->dropDownList(SwitchUser::submittedStatus(), [
                    'prompt' => 'Выберите вариант']) ?>
                <?= $form->field($model, 'countryId')->dropDownList(DictCountryHelper::countryList(), [
                    'prompt' => 'Выберите страну']) ?>
                <?= $form->field($model, 'regionId')->dropDownList(DictRegionHelper::regionList(), [
                    'prompt' => 'Выберите регион']) ?>
                <?= $form->field($model, 'userId')->widget(Select2::class, [
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
                <?= Html::submitButton("Переключиться", ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>


