<?php

/* @var $schedule modules\management\models\Schedule*/

use kartik\date\DatePicker;
$daysWork = json_encode($schedule->getAllDateTwoWeek(date('Y-m-d')));
$url = \yii\helpers\Url::to(['task/time', 'userId'=> $schedule->user_id, 'date'=>'']);
?>
<?= DatePicker::widget([
    'name' => 'dp_addon_1',
    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
    'options' => ['placeholder' => 'Введите дату завершения', 'id'=>'date'],
    'pluginOptions' => [
        'language' => 'ru',
        'autoclose' => true,
        'minDate'=> 'new Date()',
        'format' =>  'yyyy-mm-dd',
        'beforeShowDay'=> new \yii\web\JsExpression('function(d) {
                         var availableDates =  Object.keys('.$daysWork.');
                         console.log(availableDates);
                            var dmy = (d.getMonth()+1); 
                            if(d.getMonth()<9) 
                                dmy="0"+dmy; 
                            dmy+= "-"; 
                            if(d.getDate()<10) dmy+="0"; 
                                dmy+=d.getDate() + "-" + d.getFullYear(); 
                    
                            console.log(dmy+\' : \'+($.inArray(dmy, availableDates)));
                    
                            if ($.inArray(dmy, availableDates) != -1) {
                                return true; 
                            } else{
                                 return false; 
                            }
                        }'),
    ],'pluginEvents' => [
        "changeDate" => "function(e) {
           $.ajax({
        url: '{$url}'+e.target.lastChild.value,
        method: 'GET',
        async: false,
        success: function(time) {
            var items = time.result;
            var timeSelect = $('#time');
            timeSelect.val(\"\").trigger(\"change\");
            timeSelect.empty();
            timeSelect.append(\"<option value=''></option>\");
            for(var index in items) { 
                timeSelect.append($(\"<option></option>\").attr(\"value\", items[index]).text(items[index]));
            }
        },
        error: function() {
          alert('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.');
        }
    });
        }",
    ]]) ?>

<?= \kartik\select2\Select2::widget( ['data' => [], 'name' =>'time', 'options' => ['placeholder' => 'Выберите время', 'id'=> 'time'],
                    'pluginOptions' => ['allowClear' => true], 'pluginEvents' => [
        "change" => "function(e) { var date = $('#date').val(); $('#taskform-date_end').val(date+' '+e.target.value); }"]]) ?>
<?php

?>