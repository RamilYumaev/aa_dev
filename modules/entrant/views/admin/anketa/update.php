<?php
/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $anketa modules\entrant\models\Anketa */

use dictionary\helpers\DictCountryHelper;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\ProvinceOfChinaHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $anketa->profile->fio. ". Редактирование анкеты";
$this->params['breadcrumbs'][] = ['label' => 'Анкеты', 'url' => ['anketa/index']];
$this->params['breadcrumbs'][] = $this->title;
$userId = $anketa->user_id;
?>
<?= Html::a("Редактировать данные", \Yii::$app->params['staticHostInfo'] . '/switch-user/by-user-id?id=' . $userId,
    ['class' => 'btn btn-info', 'target' => '_blank']); ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\profile\ProfileWidget::widget(['userId' =>$userId,  'view' => 'index-backend']); ?>
    </div>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id' => 'anketa-form', 'options' => ['autocomplete' => 'off']]); ?>
        <?= $form->field($model, 'citizenship_id')->label("Гражданство")->dropDownList(DictCountryHelper::countryList(),
        ['prompt' => 'Выберите страну']) ?>
        <?= $form->field($model, 'province_of_china')->label("Провинция")->dropDownList(ProvinceOfChinaHelper::getName(),
        ['prompt' => 'Выберите провинцию']) ?>
        <?= $form->field($model, 'current_edu_level')->label("Образование")->dropDownList(AnketaHelper::currentEducationLevel()) ?>
        <?= $form->field($model, 'is_foreigner_edu_organization')->checkbox() ?>
        <?= $form->field($model, 'category_id')->label("Категория")->dropDownList([]) ?>
        <?= $form->field($model, 'personal_student_number')->label("Личный номер студента")->textInput(['maxlength' => true, 'placeholder' => "CHN-0143/19"]) ?>
        <?= $form->field($model, 'speciality_spo')->dropDownList(['' => 'Другое']+\dictionary\helpers\DictSpecialityHelper::specialityNameAndCodeEduLevelList(\dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO)) ?>
        <div class="m-20 text-center">
            <?= Html::submitButton("Обновить", ['class' => 'btn btn-lg btn-primary']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
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
 var personalNumber = $("div.field-anketaform-personal_student_number");
 specialitySpo.hide();
 province.hide();
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
    url: "/data-entrant/anketa/get-category",
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
    url: "/data-entrant/anketa/get-allow-education-level-by-branch",
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
