<?php
/* @var $model modules\entrant\forms\PersonalEntityForm */

/* @var $form yii\bootstrap\ActiveForm */

use modules\entrant\helpers\DateFormatHelper;
use modules\kladr\widgets\KladrAddressWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
use \borales\extensions\phoneInput\PhoneInput;

$this->title = "Форма добавления данных о законном представителе - Заказчике платных образовательных услуг";
?>
<div class="container">
    <p class="text-danger">ВНИМАНИЕ! Заполняйте поля согласно их названию, соблюдая регистр и падежи.
        Внесенные данные напрямую передаются в договор и не подлежат редактированию после отправки в приемную комиссию!</p>
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'form-personal']); ?>
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                'jsOptions' => [
                    'preferredCountries' => ['ru'],
                    'separateDialCode' => true
                ]
            ]) ?>
            <?= KladrAddressWidget::widget([
                'model' => $model,
                'form' => $form,
                'url'=> "/kladr/default",
                'mode' => KladrAddressWidget::MODE_FULL,
            ]) ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_issue')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'division_code')->widget(MaskedInput::class, ['mask' => '999-999',]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success',  "data-confirm" => " Подтверждаю, что введенные данные корректны и соответствуют заполняемым полям"]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>