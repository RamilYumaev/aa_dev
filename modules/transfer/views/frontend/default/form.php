<?php
/* @var  $this \yii\web\View  */
/* @var $model modules\transfer\models\TransferMpgu
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = "Заполнение формы";
?>
<div class="container">
    <h1><?=$this->title?></h1>
    <div class="row min-scr">
        <div class="mt-20 table-responsive">
            <?php $form = ActiveForm::begin(['id'=> 'form-transfer']); ?>
            <?= $form->field($model, 'type')->dropDownList($model->listType());?>
            <?= $form->field($model, 'number')->textInput();?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJS(<<<JS
var typeSelect = $("#transfermpgu-type");
var number = $("#transfermpgu-number");
$(typeSelect).on("change init", function() {
     if(this.value == 3){
         number.attr('disabled', true).val('');
     }else {
         number.attr('disabled', false);
     }
}).trigger("init");
JS
);