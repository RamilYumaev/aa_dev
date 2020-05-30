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
                    'prompt' => 'Выберите вариант']) ?>
                <?= $form->field($model, 'countryId')->dropDownList(DictCountryHelper::countryList(), [
                    'prompt' => 'Выберите страну']) ?>
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
var profileBlock = $(".field-switchuser-regionid");
var loadedProfiles = [];


function getList(){
    $.ajax({
    url: '/switch-user/get-list',
    method: 'GET',
    dataType: 'json',
    async: false,
    data: {submittedStatus: submittedStatus.val(), countryId: country.val(), regionId: region.val()},
    success: function(groups) {
      var profiles = groups.result;
               loadedProfiles = profiles;
            profile.val("").trigger("change");
            profile.empty();
          //  profile.append("<option value=''>Выберите пользователя</option>");
         
          for (var num in loadedProfiles){
          profile.
          append($("<option></option>").attr("value", profiles[num].id).text(profiles[num].text));
            }
        },
    })
}

submittedStatus.on("change init", function(){getList()
})
country.on("change init", function(){getList()
})
region.on("change init", function(){getList()
})

JS
);

