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
            <div class="col-md-1 col-md-offset-11">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-30">
                <h1><?= Html::encode($this->title) ?></h1>
                <?php $form = ActiveForm::begin(['id' => 'anketa-form', 'options' => ['autocomplete' => 'off']]); ?>
                <?= $form->field($model, 'citizenship_id')->dropDownList(DictCountryHelper::countryList()) ?>
                <?= $form->field($model, 'current_edu_level')->dropDownList(AnketaHelper::currentEducationLevel()) ?>
                <?= $form->field($model, 'edu_finish_year')->textInput(['maxlength' => true, 'placeholder'=> "2020"]) ?>
                <?= $form->field($model, 'category_id')->dropDownList([]) ?>
                <?= $form->field($model, 'university_choice')->dropDownList(AnketaHelper::universityChoice(),
                    ['prompt'=> 'Выберите вуз']) ?>
                <?= Html::submitButton(Html::tag("span", "",
                        ["class" => "glyphicon glyphicon-floppy-disk"]) . " " . Html::tag("span", "",
                        ["class" => "glyphicon glyphicon-arrow-right"]), ['class' => 'btn btn-lg btn-success']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$categoryVal = $model->category_id ? 1 : 0;
$this->registerJS(<<<JS
var category = $("#anketaform-category_id");
var categoryVal = $categoryVal;
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
if(categoryVal){
    category.val($model->category_id);
}  

JS
);