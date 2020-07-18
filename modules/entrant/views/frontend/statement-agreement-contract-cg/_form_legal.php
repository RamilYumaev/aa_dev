<?php
/* @var $model modules\entrant\forms\LegalEntityForm */
/* @var $form yii\bootstrap\ActiveForm */

use borales\extensions\phoneInput\PhoneInput;
use modules\entrant\helpers\DateFormatHelper;
use modules\kladr\widgets\KladrAddressWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
$this->title = "Форма добавления данных о Юридическом лице - Заказчике платных образовательных услуг";
?>
<div class="container">
    <p class="text-danger">ВНИМАНИЕ! Заполняйте поля согласно их названию, соблюдая регистр и падежи.
        Внесенные данные напрямую передаются в договор и не подлежат редактированию после отправки в приемную комиссию!</p>
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-legal']); ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
            <?= KladrAddressWidget::widget([
                'model' => $model,
                'form' => $form,
                'url'=> "/kladr/default",
                'mode' => KladrAddressWidget::MODE_FULL,
            ]) ?>
            <?= $form->field($model, 'address_postcode')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'footing')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'requisites')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'bik')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'p_c')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'k_c')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'ogrn')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                'jsOptions' => [
                    'preferredCountries' => ['ru'],
                    'separateDialCode'=>true
                ]
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', "data-confirm" => " Подтверждаю, что введенные данные корректны и соответствуют заполняемым полям"]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>