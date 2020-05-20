<?php

use \yii\web\View;

/* @var $model modules\entrant\forms\AnketaForm */

/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \modules\entrant\helpers\AnketaHelper;
use \dictionary\helpers\DictCountryHelper;
use kartik\select2\Select2;
use \modules\entrant\helpers\ProvinceOfChinaHelper;

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
                    ['prompt' => 'Выберите отделение университета']) ?>
                <?= $form->field($model, 'citizenship_id')->dropDownList(DictCountryHelper::countryList(),
                    ['prompt' => 'Выберите страну']) ?>
                <?= $form->field($model, 'province_of_china')->dropDownList(ProvinceOfChinaHelper::getName(),
                    ['prompt' => 'Выберите провинцию']) ?>
                <?= $form->field($model, 'current_edu_level')->dropDownList([]) ?>
                <?= $form->field($model, 'edu_finish_year')->textInput(['maxlength' => true, 'placeholder' => "2020"]) ?>
                <?= $form->field($model, 'category_id')->dropDownList([]) ?>
                <?= $form->field($model, 'personal_student_number')->textInput(['maxlength' => true, 'placeholder' => "CHN-0143/19"]) ?>
                <div class="m-20 text-center">
                    <?= Html::submitButton(Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-floppy-disk"]) . " " . Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-arrow-right"]), ['class' => 'btn btn-lg btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?php

$categoryVal = $model->category_id ? $model->category_id : 0;
$educationVal = $model->current_edu_level ? $model->current_edu_level : 0;
$govLineCategoryId = \modules\entrant\helpers\CategoryStruct::GOV_LINE_COMPETITION;

$this->registerJS(<<<JS
var category = $("#anketaform-category_id");
var education = $("#anketaform-current_edu_level");
var categoryVal = $categoryVal;
var educationVal = $educationVal;
var govLineCategoryId = $govLineCategoryId;
const rf = 46;
const rk = 29;
const rb = 49;
const kr = 35;
const rt = 30;
var loadedCat = [];
var loadedEdu = [];


var currentCountry = $("#anketaform-citizenship_id");
var currentEducationLevel = $("#anketaform-current_edu_level");
var currentUniversityChoice = $("#anketaform-university_choice");
var foreignerStatus;
  
  
  function foreignerStatusValue()
  {if(currentCountry.val() == rf || currentCountry.val() == kr || currentCountry.val() == rb || currentCountry.val() == rk 
  || currentCountry.val() == rt)
    {foreignerStatus= 0;}else{foreignerStatus= 1;} return foreignerStatus;
  }
  
  function ajaxReactive(foreignerStatus = 0, educationLevel = 1, universityChoice = 1)
  {
      if(!educationLevel)
          {
              educationLevel = $educationVal;
          }
      $.ajax({
    url: "/abiturient/anketa/get-category",
    method: "GET",
    dataType: "json",
    async: false,
    data: {foreignerStatus: foreignerStatus, educationLevel: educationLevel, universityChoice: universityChoice},
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
  }
  
    currentCountry.on("change init", function() {ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), 
    currentUniversityChoice.val());}) 
    currentEducationLevel.on("change init", function() {ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), 
    currentUniversityChoice.val());}) 
    currentUniversityChoice.on("change init", function() {
        ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), currentUniversityChoice.val());
        ajaxEducationlevel(currentUniversityChoice.val());
    }) 
    
  currentCountry.trigger("init");
  currentEducationLevel.trigger("init");
  currentUniversityChoice.trigger("init");
if(categoryVal){
    category.val($model->category_id);
} 
if(educationVal){
    education.val($model->current_edu_level);
}

    var province = $("div.field-anketaform-province_of_china");
    var countryId = $("#anketaform-citizenship_id");
    var provinceText = $("#anketaform-province_of_china");
    var category = $("#anketaform-category_id");
    var personalNumber = $("div.field-anketaform-personal_student_number");
    var personalNumberVal = $("#anketaform-personal_student_number");
    province.hide();
    personalNumber.hide();

    const china = 13; //@TODO

    if(countryId.val()== china) {
        province.show();
    }else {
        province.hide();
    }
    
    if(category.val() == govLineCategoryId)
        {
            personalNumber.show();
        }else{
        personalNumber.hide();
        }
    
    category.on("change", function(){
         if (this.value == "") {
         personalNumber.hide();
         personalNumberVal.val("");
        } else if (this.value == govLineCategoryId) {
         personalNumber.show();
        }
        else {
        personalNumber.hide();
        personalNumberVal.val("");
            }
    });

    countryId.on("change", function() {
        if (this.value == "") {
            province.hide();
            provinceText.val("");
        } else if (this.value == china) {
            province.show();
        }
        else {
            province.hide();
            provinceText.val("");
            }
    });
JS
);