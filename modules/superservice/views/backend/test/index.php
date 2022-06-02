<?php

/* @var $this yii\web\View */
/* @var $provider yii\data\ArrayDataProvider */
/* @var $fields array */
/* @var $model \yii\base\DynamicModel */

$this->title = 'Тест';
$this->params['breadcrumbs'][] = $this->title;

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>

<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= \yii\helpers\Html::dropDownList('marek', '', (new \modules\superservice\components\data\
            DocumentTypeList())
                ->getArray()
                ->sort(['Name'], [SORT_ASC])->map('Id', 'Name'), ['id' => 'select']) ?>
            <?= \yii\helpers\Html::dropDownList('version', '',[], ['id' => 'version']) ?>
        </div>
        <?php if($fields && $model) :
            $form = \yii\widgets\ActiveForm::begin(['id'=> 'dynamic']); ?>
            <?php foreach($fields['names'] as $value): ?>
                <?php if(key_exists('clsName', $fields) && key_exists($value, $fields['clsName'])):
                      /** @var \modules\superservice\components\DataXml $class */
                     $class = '\\modules\\superservice\\components\\data\\'.$fields['clsName'][$value]; ?>
                    <?= $form->field($model, $value)->widget(Select2::class, [
                        'data' =>(new $class())->getDefaultMap(),
                        'options' => ['placeholder' => 'Выберите ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
            ]) ?>
                <?php  elseif(key_exists('boolean', $fields["formats"]) && in_array($value, $fields["formats"]['boolean'])): ?>
                    <?= $form->field($model, $value)->checkbox() ?>
                <?php else: ?>
                    <?= $form->field($model, $value)->textInput() ?>
            <?php endif; endforeach; ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end();
        endif; ?>
    </div>
</div>

<?php
$this->registerJs(<<<JS
"use strict";
// фильтруем список конкурсных групп
var select = $('#select');
var version = $('#version');
version.hide();
   select.on("change init", function() {
    $.ajax({
        url: "/super-service/test/doc",
        method: "GET",
        dataType: "json",
        data: {selectOn: select.val()},
        async: false,
        success: function(v) {
            var items = v.result;
            console.log(items);
            version.show();
            version.empty();
            for(var i = 0; i < items.length; ++i) {
                version.append($("<option></option>").attr("value", items[i].Id).text(items[i].DocVersion));
            }
        },
        error: function() {
          alert('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.');
        }
    });
});
   
select.trigger('init');
JS
);

