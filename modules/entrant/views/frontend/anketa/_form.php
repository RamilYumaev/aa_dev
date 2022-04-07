<?php

use yii\helpers\Url;
use \yii\web\View;

/* @var $model modules\entrant\forms\AnketaForm */

/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \modules\entrant\helpers\AnketaHelper;
use \dictionary\helpers\DictCountryHelper;
use \modules\entrant\helpers\ProvinceOfChinaHelper;

$model->speciality_spo = is_null($model->speciality_spo) ? '' : $model->speciality_spo;
$docUrl = Html::a("Ознакомиться", 'https://docs.google.com/document/d/1ziiGMWfpqqBbdiOze-HrHgOmZHCdDqyI8g9KZBaZScU/edit',['target'=> "_blank"]);
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
                <?= $form->field($model, 'citizenship_id')->dropDownList(DictCountryHelper::countryList(),
                    ['prompt' => 'Выберите страну']) ?>
                <?= $form->field($model, 'province_of_china')->dropDownList(ProvinceOfChinaHelper::getName(),
                    ['prompt' => 'Выберите провинцию']) ?>
                <?= $form->field($model, 'current_edu_level')->dropDownList(AnketaHelper::currentEducationLevel()) ?>
                <?= $form->field($model, 'is_foreigner_edu_organization')->checkbox() ?>
                <?= $form->field($model, 'category_id')->dropDownList([]) ?>
                <?= $form->field($model, 'is_dlnr_ua')->checkbox() ?>
                <?= $form->field($model, 'personal_student_number')->textInput(['maxlength' => true, 'placeholder' => "CHN-0143/19"]) ?>
                <?= $form->field($model, 'speciality_spo')
                    ->dropDownList(['' => 'Другое']+\dictionary\helpers\DictSpecialityHelper::specialityNameAndCodeEduLevelList(\dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO)) ?>
                <?= $form->field($model, 'is_agree')->checkbox([
                    'template' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>
                $docUrl\n{error}\n{endWrapper}\n{hint}",
                ]) ?>
                <div class="m-20 text-center">
                    <?= Html::submitButton(Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-floppy-disk"]) . " " . Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-arrow-right"]), ['class' => 'btn btn-lg btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <p>* - если Вы закончили специалитет набора 2011 года или позднее, обратитесь к специалистам приёмной комиссии для уточнения квалификации: priem@mpgu.su.</p>
    </div>

<?php

$categoryVal = $model->category_id ? $model->category_id : 0;
$educationVal = $model->current_edu_level ? $model->current_edu_level : 0;
$govLineCategoryId = \modules\entrant\helpers\CategoryStruct::GOV_LINE_COMPETITION;
$educationValSpo = AnketaHelper::SCHOOL_TYPE_SPO;
$this->registerJS(<<<JS
var category = $("#anketaform-category_id");
var education = $("#anketaform-current_edu_level");
var categoryVal = $categoryVal;
var educationVal = $educationVal;
var govLineCategoryId = $govLineCategoryId;
var educationSPO = $educationValSpo;
const rf = 46;
const rk = 29;
const rb = 49;
const kr = 35;
const rt = 30;
var loadedCat = [];
var loadedEdu = [];

 var province = $("div.field-anketaform-province_of_china");
 var specialitySpo = $("div.field-anketaform-speciality_spo");
 var isDlnrUa = $("div.field-anketaform-is_dlnr_ua");
 var personalNumber = $("div.field-anketaform-personal_student_number");
 specialitySpo.hide();
 province.hide();
 isDlnrUa.hide();
 personalNumber.hide();
var currentCountry = $("#anketaform-citizenship_id");
var currentEducationLevel = $("#anketaform-current_edu_level");
var currentUniversityChoice = $("#anketaform-university_choice");
var foreignerStatus;
var universityChoice;
  
  
  function foreignerStatusValue()
  {if(currentCountry.val() == rf || currentCountry.val() == kr || currentCountry.val() == rb || currentCountry.val() == rk 
  || currentCountry.val() == rt)
    {foreignerStatus= 0;}else{foreignerStatus= 1;} return foreignerStatus;
  }
  
  function universityChoiceValue()
  {if(currentCountry.val() == kr || currentCountry.val() == rb || currentCountry.val() == rk 
  || currentCountry.val() == rt)
    {universityChoice= 1;}else{universityChoice= 0;} return universityChoice;
  }
  
  function ajaxReactive(foreignerStatus = 0, educationLevel = 1, universityChoice = 0)
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
    universityChoiceValue());}) 
    currentEducationLevel.on("change init", function() {ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), 
    universityChoiceValue());}) 
    currentUniversityChoice.on("change init", function() {
        ajaxReactive(foreignerStatusValue(), currentEducationLevel.val(), universityChoiceValue());
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

if(educationVal == educationSPO){
    specialitySpo.show();
}

   
    var countryId = $("#anketaform-citizenship_id");
    var provinceText = $("#anketaform-province_of_china");
    var dlnrUaValue = $("#anketaform-is_dlnr_ua");
    var category = $("#anketaform-category_id");
   
    var personalNumberVal = $("#anketaform-personal_student_number");
    province.hide();
    personalNumber.hide();

    const china = 13; //@TODO

    if(countryId.val()== china) {
        province.show();
    }else {
        province.hide();
    }
    
     if(countryId.val()== rf) {
        isDlnrUa.show();
    }else {
        isDlnrUa.hide();
    }
    
    if(category.val() == govLineCategoryId)
        {
            personalNumber.show();
        }else{
        personalNumber.hide();
        }
    
    education.on("change init", function(){
         if (this.value == "") {
          specialitySpo.hide();
         specialitySpo.val(null);
        } else if (this.value == educationSPO) {
         specialitySpo.show();
        }
        else {
        specialitySpo.hide();
         specialitySpo.val(null);
        }
    });
    
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
            dlnrUaValue.val(0)
            isDlnrUa.hide();
            provinceText.val("");
        } else if (this.value == china) {
            province.show();
        } else if(this.value == rf) {
            isDlnrUa.show();
        }
        else {
            dlnrUaValue.val(0)
            isDlnrUa.hide();
            province.hide();
            provinceText.val("");
            }
    });
JS
);