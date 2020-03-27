<?php
/* @var $model modules\entrant\forms\AddressForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\helpers\AddressHelper;
use modules\kladr\widgets\KladrAddressWidget;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-address']); ?>
            <?= $form->field($model, 'country_id')->dropDownList(DictCountryHelper::countryList(), ['prompt'=> 'Выберите страну']) ?>
            <?= $form->field($model, 'type')->dropDownList(AddressHelper::typeOfAddress()) ?>
            <?= KladrAddressWidget::widget([
                'model' => $model,
                'form' => $form,
                'mode' => KladrAddressWidget::MODE_FULL,
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>