<?php

/* @var $model modules\entrant\forms\AnketaForm */

/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \modules\entrant\helpers\AnketaHelper;
use \dictionary\helpers\DictCountryHelper;
use kartik\select2\Select2;

?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-30">
                <h1><?= Html::encode($this->title) ?></h1>
                <?php $form = ActiveForm::begin(['id' => 'anketa-form']); ?>
                <?= $form->field($model, 'citizenship_id')->dropDownList(DictCountryHelper::countryList()) ?>
                <?= $form->field($model, 'current_edu_level')->dropDownList(AnketaHelper::currentEducationLevel()) ?>
                <?= $form->field($model, 'edu_finish_year')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'category_id')->dropDownList([]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Далее', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJS(<<<JS
var category = $("#anketaform-category_id");
const rf = 46;
const rk = 29;
const rb = 49;
const kr = 35;
const rt = 30;
var loadedCat = [];


var curentCountry = $("#anketaform-citizenship_id");
var curentCountrySelect = $("#anketaform-citizenship_id");
var foreignerStatus;

    
  curentCountry.on("change init", function() {
      
if(curentCountry.val() == rf 
|| curentCountry.val() == kr 
|| curentCountry.val() == rb 
|| curentCountry.val() == rk
|| curentCountry.val() == rt)
    {
        foreignerStatus= 0;

    }else{
    
    foreignerStatus= 1;

    }
    $.ajax({
    url: "/abiturient/anketa/get-category",
    method: "GET",
    dataType: "json",
    async: false,
    data: {foreignerStatus: foreignerStatus},
    success: function (groups){
         var cat = groups.result;
         loadedCat = cat;
            category.val("").trigger("change");
            category.empty();
            category.append("<option value=''>Укажите категорию</option>");
         
          for (var num in cat){
          category.
          append($("<option></option>").attr("value", cat[num].id).text(cat[num].text));
            }
        },
    })
  })  
    
  curentCountrySelect.trigger("init");
JS
);