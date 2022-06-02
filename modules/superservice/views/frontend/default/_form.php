<?php

/* @var $this yii\web\View */
/* @var $provider yii\data\ArrayDataProvider */
/* @var $fields array */
/* @var $model \modules\superservice\forms\SelectTypeDocumentsForm */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
    <div class="forms_data">
        <?php $form = ActiveForm::begin(['id'=> 'select_document']); ?>
        <?= $form->field($model, 'type')->dropDownList($model->getDocumentTypeWithCategoryList(), ['id'=> 'select']) ?>
        <?= $form->field($model, 'version')->dropDownList([], ['id'=> 'version']) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
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
        url: "/ss/default/doc",
        method: "GET",
        dataType: "json",
        data: {selectOn: select.val()},
        async: false,
        success: function(v) {
            var items = v.result;
            console.log(items);
             version.empty();
             version.show();
             for(var i = 0; i < items.length; ++i) {
                 version.append($("<option></option>").attr("value", items[i].Id).text(items.length === 1 ? "Нет версии" : items[i].DocVersion));
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


