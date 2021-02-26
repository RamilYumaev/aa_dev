<?php
/* @var $model modules\management\forms\ScheduleForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $schedule modules\management\models\Schedule */

use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use modules\management\models\PostRateDepartment;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$setting = [
    'convertFormat'=>true,
    'pluginOptions'=>[
        "timePicker"=> true,
        "timePicker24Hour"=> true,
        'timePickerIncrement'=>15,
        'locale'=>['format'=>'H:i', 'separator'=>'-',]
    ],
    'pluginEvents' => [
        "show.daterangepicker" => 'function (ev, picker) { picker.container.find(".calendar-table").hide();
               }',
    ]
    ];
?>
<div class="box">
    <div class="box-header"><?= Html::a("Взять отгул", ['date-off/create'], ['class'=> 'btn btn-info'])?></div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-schedule']); ?>
        <?php if(!$schedule || ($schedule && !$schedule->isBlocked)): ?>
        <?= $form->field($model, 'postList')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'pluginEvents' => ["select2:select" => "function(e) {
             var val = e.params.data.text;
              if(val.indexOf('Полная ставка') >= 0 || val.indexOf('1,25 ставки') >= 0  || val.indexOf('1,5 ставки') >= 0)  {
                    setValueTime(blockWeekOdd, '09:30-18:15', '09:30-17:15');
                    setValueTime(blockWeekEven, '09:30-18:15', '09:30-17:15');
              }
               }",
                "select2:unselect" => "function(e) {  
                    console.log(e);
                    setValueTime(blockWeekOdd, '', '');
                    setValueTime(blockWeekEven, '', '');
                   }",
                ],
            'data' => PostRateDepartment::find()->getAllColumn()
        ]) ?>
        <?php endif; ?>
        <?= $form->field($model, 'email')->textInput()?>
        <div class="row">
            <div class="col-md-6">
                <h4>Нечетная неделя</h4>
                <div id="week_odd">
                    <?= $form->field($model, 'monday_odd')->widget(DateRangePicker::class, $setting)?>
                    <?= $form->field($model, 'tuesday_odd')->widget(DateRangePicker::class, $setting) ?>
                    <?= $form->field($model, 'wednesday_odd')->widget(DateRangePicker::class, $setting) ?>
                    <?= $form->field($model, 'thursday_odd')->widget(DateRangePicker::class, $setting) ?>
                    <?= $form->field($model, 'friday_odd')->widget(DateRangePicker::class, $setting) ?>
                </div>
                <?= $form->field($model, 'saturday_odd')->widget(DateRangePicker::class, $setting)?>
                <?= $form->field($model, 'sunday_odd')->widget(DateRangePicker::class, $setting) ?>
            </div>
            <div class="col-md-6">
                <h4>Четная неделя</h4>
                <div id="week_even">
                    <?= $form->field($model, 'monday_even')->widget(DateRangePicker::class, $setting)?>
                    <?= $form->field($model, 'tuesday_even')->widget(DateRangePicker::class, $setting) ?>
                    <?= $form->field($model, 'wednesday_even')->widget(DateRangePicker::class, $setting) ?>
                    <?= $form->field($model, 'thursday_even')->widget(DateRangePicker::class, $setting) ?>
                    <?= $form->field($model, 'friday_even')->widget(DateRangePicker::class, $setting) ?>
                </div>
                <?= $form->field($model, 'saturday_even')->widget(DateRangePicker::class, $setting)?>
                <?= $form->field($model, 'sunday_even')->widget(DateRangePicker::class, $setting) ?>
            </div>
        </div>
        <?= $form->field($model, 'vacation')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs(<<<JS
"use strict";
// фильтруем список конкурсных групп
var blockWeekEven =  $('#week_even');
var blockWeekOdd =  $('#week_odd');
function setValueTime(selectorBlock, valTime, valTimeFriday) {
       selectorBlock.find('input[type="text"]').each(function(i, v) {
            if($(v).attr('id').search('friday') != -1) {
                $(v).val(valTimeFriday);
            }else {
                $(v).val(valTime);
            }
        });     
    }
JS
);
