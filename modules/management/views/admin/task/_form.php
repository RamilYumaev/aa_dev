<?php
/* @var $model modules\management\forms\TaskForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $this yii\web\View */

use backend\assets\modal\ModalAsset;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use modules\management\models\DictTask;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

ModalAsset::register($this);
$model->date_begin = date("Y-m-d");
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-task']); ?>
        <div class="row">
            <div class="col-md-7">
                <?= $form->field($model, 'director_user_id')->widget(Select2::class, [
                    'data' => ManagementUser::find()->allColumn(),
                    'options' => ['placeholder' => 'Выберите постановщика'],
                    'pluginOptions' => ['allowClear' => true],
                ]);?>
                <?= $form->field($model, 'dict_task_id')->widget(Select2::class, [
                    'data' =>DictTask::find()->allColumn(),
                    'options' => ['placeholder' => 'Выберите функцию/задачу'],
                    'pluginOptions' => ['allowClear' => true],
                ]);?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'text')->widget(CKEditor::class, [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
                ]); ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'date_begin')->widget(DatePicker::class, [
                    'options' => ['placeholder' => 'Введите дату начала исполнения'],
                    'pluginOptions' => [
                        'language' => 'ru',
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
                <?= $form->field($model, 'responsible_user_id')->widget(Select2::class, [
                    'data' => Schedule::find()->getAllColumnDirector(),
                    'options' => ['placeholder' => 'Выберите постановщика'],
                    'pluginOptions' => ['allowClear' => true],
                ])?>
                <?= Html::a("Выбрать дату крайнего срока", ["task/work"], ["class" => "btn btn-danger", "id"=>"modal-button",
                    'data-pjax' => 'w5454',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'data-modalTitle' => 'Выберите дату крайнего срока'])?>

                <?= $form->field($model, 'date_end')->textInput(['readonly'=> true]); ?>

                <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$url = \yii\helpers\Url::to(['task/work','userId'=>'']);
$urlTask = \yii\helpers\Url::to(['task/task']);
$this->registerJs(<<<JS
"use strict";
var modal = $('#modal-button');
var responsibleSelect = $('#taskform-responsible_user_id');
var distTaskSelect = $('#taskform-dict_task_id');

responsibleSelect
    .on("change init", function() {
        if($(this).val()) {
            modal.show();
            var url = '{$url}';
            modal.attr('href', url + $(this).val());
        }else {
            modal.hide();
            $('#taskform-date_end').val("");
        }
}).trigger('init');
distTaskSelect.on('change', function() {
  $.ajax({
        url: '{$urlTask}',
        method: 'GET',
        async: false,
        dataType: "json",
        data: {task: distTaskSelect.val()},
        success: function(result) {
            var items = result.result;
            console.log(items);
            responsibleSelect.val('').trigger("change");
            responsibleSelect.empty();
            responsibleSelect.append("<option value=''></option>");
            for(var index in items) { 
                responsibleSelect.append($("<option></option>").attr("value", index).text(items[index]));
            }
        },
        error: function() {
          alert('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.');
        }
    });
});

JS
);
