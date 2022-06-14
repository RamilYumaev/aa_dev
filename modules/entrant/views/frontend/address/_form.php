<?php
/* @var $model modules\entrant\forms\AddressForm */
/* @var $form yii\bootstrap\ActiveForm */

use dictionary\helpers\DictRegionHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\helpers\AddressHelper;
use modules\kladr\widgets\KladrAddressWidget;
?>
<div class="row min-scr">
    <div class="button-left">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-address']); ?>
            <?= $form->field($model, 'country_id')->dropDownList(DictCountryHelper::countryList(), ['prompt'=> 'Выберите страну']) ?>
            <?= $form->field($model, 'region_id')->dropDownList(DictRegionHelper::regionList(), ['prompt'=> 'Выберите регион']) ?>
            <?= $form->field($model, 'type')->dropDownList(AddressHelper::typeOfAddress()) ?>
            <?= KladrAddressWidget::widget([
                'model' => $model,
                'form' => $form,
                'url'=> "/kladr/default",
                'mode' => KladrAddressWidget::MODE_FULL,
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJS(<<<JS
var country = $("#addressform-country_id");
const russia = 46;
const other  = 86;
var regionField = $('.field-addressform-region_id');
var region = $("#addressform-region_id");
regionField.hide();
$(country).on("change init", function() {
     if(this.value == russia){
        regionField.show();
     }else {
         region.val('');
         regionField.hide();
     }
}).trigger("init");
JS
);