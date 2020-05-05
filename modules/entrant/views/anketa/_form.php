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
                <?= $form->field($model, 'university_choice')->dropDownList(AnketaHelper::universityChoice(),
                    ['prompt'=> 'Выберите отделение университета']) ?>
                <?= $form->field($model, 'citizenship_id')->dropDownList(DictCountryHelper::countryList(),
                    ['prompt'=> 'Выберите страну']) ?>
                <?= $form->field($model, 'current_edu_level')->dropDownList([]) ?>
                <?= $form->field($model, 'edu_finish_year')->textInput(['maxlength' => true, 'placeholder'=> "2020"]) ?>
                <?= $form->field($model, 'category_id')->dropDownList([]) ?>

                <?= Html::submitButton(Html::tag("span", "",
                        ["class" => "glyphicon glyphicon-floppy-disk"]) . " " . Html::tag("span", "",
                        ["class" => "glyphicon glyphicon-arrow-right"]), ['class' => 'btn btn-lg btn-success']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$categoryVal = $model->category_id;
$educationVal = $model->current_edu_level;
$this->registerJS(<<<JS
var category = $("#anketaform-category_id");
var education = $("#anketaform-current_edu_level");
var categoryVal = $categoryVal;
var educationVal = $educationVal;
const rf = 46;
const rk = 29;
const rb = 49;
const kr = 35;
const rt = 30;
var loadedCat = [];
var loadedEdu = [];


var curentCountry = $("#anketaform-citizenship_id");
var curentCountrySelect = $("#anketaform-citizenship_id");
var currentEducationLevel = $("#anketaform-current_edu_level");
var currentUniversityChoice = $("#anketaform-university_choice");
var foreignerStatus;

console.log(currentUniversityChoice.val());
  
  function foreignerStatusValue()
  {if(curentCountry.val() == rf || curentCountry.val() == kr || curentCountry.val() == rb || curentCountry.val() == rk 
  || curentCountry.val() == rt)
    {foreignerStatus= 0;}else{foreignerStatus= 1;} return foreignerStatus;
  }
  
  function ajaxReactive(foreignerStatus = 0 , educationLevel = 1, universityChoice = 1)
  {
      if(!educationLevel)
          {
              educationLevel = $model->current_edu_level;
          }
      
    $.ajax({
    url: "/abiturient/anketa/get-category",
    method: "GET",
    dataType: "json",
    async: false,
    data: {foreignerStatus: foreignerStatus, educationLevel: educationLevel, universityChoice},
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
  };
  
  function ajaxEducationlevel(universityId)
  {
    $.ajax({
    url: "/abiturient/anketa/get-allow-education-level-by-branch",
    method: "GET",
    dataType: "json",
    async: false,
    data: {universityId: universityId},
    success: function (groups){
         var edu = groups.result;
         loadedEdu = edu;
            education.val("").trigger("change");
            education.empty();
            education.append("<option value=''>Выберите уровень образования РФ</option>");
         
          for (var num in edu){
          education.
          append($("<option></option>").attr("value", edu[num].id).text(edu[num].text));
            }
        },
    })
  };
  
    curentCountry.on("change init", function() {ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), 
    currentUniversityChoice.val());}) 
    currentEducationLevel.on("change init", function() {ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), 
    currentUniversityChoice.val());}) 
    currentUniversityChoice.on("change init", function() {
        ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), currentUniversityChoice.val());
        ajaxEducationlevel(currentUniversityChoice.val());
    }) 
    
  curentCountrySelect.trigger("init");
  currentEducationLevel.trigger("init");
  currentUniversityChoice.trigger("init");
  
if(categoryVal){
    category.val($model->category_id);
} 
if(educationVal){
    education.val($model->current_edu_level);
}


JS
);