<?php
/* @var $model modules\entrant\forms\PassportDataForm */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $neededCountry bool */

use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
use \dictionary\helpers\DictCountryHelper;

\modules\entrant\assets\passport\PassportAsset::register($this)
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <p class="label label-warning fs-15">Заполнять нужно строго как в документе</p>
            <h1><?= Html::encode($this->title) ?></h1>
            <?= \modules\superservice\widgets\ButtonChangeVersionDocumentsWidgets::widget(['category'=>json_encode([1]), 'document' => $model->type_document, 'version' =>  $model->version_document])?>
            <?php $form = ActiveForm::begin(['id' => 'form-passport']); ?>
            <?php if ($neededCountry): ?>
                <?= $form->field($model, 'nationality')->label('Страна выдачи')->dropDownList(DictCountryHelper::countryList()) ?>
            <?php else : ?>
                <?php if (!$model->anketa): ?>
                    <?= $form->field($model, 'nationality')->label('Гражданство')->dropDownList(DictCountryHelper::countryList()) ?>
                <?php endif; ?>
                <?= $form->field($model, 'type')->dropDownList(DictIncomingDocumentTypeHelper::listPassport($model->nationality)) ?>
            <?php endif; ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_birth')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?php if (!$neededCountry): ?>
                <?= $form->field($model, 'place_of_birth')->textInput(['maxlength' => true]) ?>
            <?php endif; ?>
            <?= $form->field($model, 'date_of_issue')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
            <?php if (!$neededCountry): ?>
                <?= $form->field($model, 'division_code')->widget(MaskedInput::class, ['mask' => '999-999',]) ?>
            <?php endif; ?>
            <?php if($dynamic): ?>
                <?= \modules\superservice\widgets\FormVersionDocumentsWidgets::widget(['dynamicModel' => $dynamic, 'form'=> $form ]) ?>
            <?php endif; ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>