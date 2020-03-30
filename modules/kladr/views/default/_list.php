<?php

use modules\kladr\models\Kladr;
use kartik\select2\Select2;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var string $widgetId */

$widgetId = Html::encode($widgetId);
?>

    <label class="control-label">Регион.</label>
<?= Select2::widget([
    'name' => 'kladr-regions',
    'id' => "{$widgetId}-select2-kladr-regions",
    'options' => ['placeholder' => 'Выберите регион'],
    'data' => Kladr::getRegions()
]); ?>
    <br/>

    <label class="control-label">Район (улус).</label>
<?= Select2::widget([
    'name' => 'kladr-districts',
    'id' => "{$widgetId}-select2-kladr-districts",
    'options' => ['placeholder' => 'Выберите район (улус)'],
    'pluginOptions' => ['allowClear' => true],
    'data' => [],
]); ?>
    <br/>

    <label class="control-label">Города и поселки городского типа регионального и районного подчинения;
        сельсоветы (сельские округа, сельские администрации, волости).</label>
<?= Select2::widget([
    'name' => 'kladr-cities',
    'id' => "{$widgetId}-select2-kladr-cities",
    'options' => ['placeholder' => 'Выберите город, пгт или сельсовет'],
    'pluginOptions' => ['allowClear' => true],
    'data' => [],
]); ?>
    <br/>

    <label class="control-label">Города и поселки городского типа, подчиненные администрациям городов
        третьего уровня; сельские населенные пункты.</label>
<?= Select2::widget([
    'name' => 'kladr-villages',
    'id' => "{$widgetId}-select2-kladr-villages",
    'options' => ['placeholder' => 'Выберите город, пгт или посёлок'],
    'pluginOptions' => ['allowClear' => true],
    'data' => [],
]); ?>
    <br/>

    <label class="control-label">Улица.</label>
<?= Select2::widget([
    'name' => 'kladr-streets',
    'id' => "{$widgetId}-select2-kladr-streets",
    'options' => ['placeholder' => 'Выберите улицу'],
    'pluginOptions' => ['allowClear' => true],
    'data' => [],
]); ?>
    <br/>

    <label class="control-label">Дом.</label>
<?= Select2::widget([
    'name' => 'kladr-houses',
    'id' => "{$widgetId}-select2-kladr-houses",
    'options' => ['placeholder' => 'Выберите дом'],
    'pluginOptions' => ['allowClear' => true],
    'data' => [],
]); ?>
    <br/>

    <label class="control-label">Индекс.</label>
<?= Html::textInput('', null, ['id' => "{$widgetId}-postcode", 'class' => 'form-control', 'readonly' => 'readonly']); ?>
    <br/>

<?= Html::button('Готово', ['class' => 'btn btn-success']); ?>

<?php
$this->registerJs(<<<JS
var regions = $("#{$widgetId}-select2-kladr-regions");
var districts = $("#{$widgetId}-select2-kladr-districts");
var cities = $("#{$widgetId}-select2-kladr-cities");
var villages = $("#{$widgetId}-select2-kladr-villages");
var streets = $("#{$widgetId}-select2-kladr-streets");
var houses = $("#{$widgetId}-select2-kladr-houses");

var getLocations = function(url, from, to) {
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        async: false,
        data: {id: from.value},
        success: function(result) {
            var items = result.items;
            to.empty();
            to.append("<option value=''></option>");
            for(var i = 0; i < items.length; ++i) {
                to.append("<option value=" + items[i].id + ">" + items[i].text + "</option>");
            }
        },
        error: function() {
            alert("Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.");
        }
    });
};

regions.on("change", function() {
    getLocations("/kladr/default/get-districts", this, districts);
    getLocations("/kladr/default/get-cities", this, cities);
    getLocations("/kladr/default/get-streets", this, streets);
});

districts.on("change", function() {
    getLocations("/kladr/default/get-cities", this, cities);
    getLocations("/kladr/default/get-villages", this, villages);
});

cities.on("change", function() {
    getLocations("/kladr/default/get-villages", this, villages);
    getLocations("/kladr/default/get-streets", this, streets);
});

villages.on("change", function() {
    getLocations("/kladr/default/get-streets", this, streets);
});

streets.on("change", function() {
    getLocations("/kladr/default/get-houses", this, houses);
});
JS
);
