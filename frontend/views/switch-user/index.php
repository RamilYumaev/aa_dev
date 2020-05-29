<?php


use yii\widgets\ActiveForm;
use \olympic\helpers\auth\ProfileHelper;
use yii\helpers\Html;
use kartik\select2\Select2;
use \common\auth\models\SwitchUser;
use \dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;

$this->title = "Форма переключения на другого пользователя";
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="container mt-50">
        <h1><?= $this->title ?></h1>
        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(['id' => 'form-switch-user', 'options' => ['autocomplete' => 'off']]); ?>
                <?= $form->field($model, 'submittedStatus')->dropDownList(SwitchUser::submittedStatus(), [
                    'prompt' => 'Выберите вариант', 'value' => 10]) ?>
                <?= $form->field($model, 'countryId')->dropDownList(DictCountryHelper::countryList(), [
                    'prompt' => 'Выберите страну', 'value' => 46]) ?>
                <?= $form->field($model, 'regionId')->dropDownList(DictRegionHelper::regionList(), [
                    'prompt' => 'Выберите регион']) ?>
                <?= $form->field($model, 'userId')->widget(Select2::class, [
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
                <?= Html::submitButton("Переключиться", ['class' => 'btn btn-success']) ?>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>


<?php
$this->registerJS(<<<JS

var submittedStatus = $("#switchuser-submittedstatus");
var country = $("#switchuser-countryid");
var region = $("#switchuser-regionid");
var profile = $("#switchuser-userid");
var loadedProfiles = [];

if(!country.val())
    {
        country = 46;
    }

if(!submittedStatus.val())
    {
        submittedStatus = 10;
    }

profile.show();

if(country !== 46) //@todo
    {
        profile.hide();
        profile.val("");
    }


function getList(){
    $.ajax({
    url: '/switch-user/get-list',
    method: 'GET',
    dataType: 'json',
    async: false,
    date: {submittedStatus: submittedStatus.val(), countryId: country.val(), regionId: region.val()},
    success: function(groups) {
      var profiles = groups.result;
               loadedProfiles = profiles;
            profile.val("").trigger("change");
            profile.empty();
            profile.append("<option value=''>Выберите пользователя</option>");
         
          for (var num in loadedProfiles){
          profile.
          append($("<option></option>").attr("value", profiles[num].id).text(profiles[num].text));
            }
        },
    })
}

submittedStatus.on("change init", function(){getList()
console.log(submittedStatus.val(), country.val(),region.val())
})
country.on("change init", function(){getList()
console.log(submittedStatus.val(), country.val(),region.val())
})
region.on("change init", function(){getList()
console.log(submittedStatus.val(), country.val(),region.val())
})


JS
);

