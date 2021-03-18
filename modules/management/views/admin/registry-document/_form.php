<?php
/* @var $model modules\management\forms\RegistryDocumentForm*/
/* @var $form yii\bootstrap\ActiveForm */

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-registry']); ?>
        <?= $form->field($model, 'access')->dropDownList((new \modules\management\models\RegistryDocument())->getAccessList()) ?>
        <?= $form->field($model, 'dict_department_id')->dropDownList(\modules\management\models\DictDepartment::find()->allColumn(),['prompt'=> 'Выберите отдел']) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'category_document_id')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите...'],
            'data' => \modules\management\models\CategoryDocument::find()->allColumn()
        ]) ?>
        <?= $form->field($model, 'file')->widget(FileInput::class, ['language'=> 'ru']);?>
        <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerJs(<<<JS
var department = $("div.field-registrydocumentform-dict_department_id");

$("#registrydocumentform-access").on("change init", function() {
    if(this.value == 2){
        department.show();
        }else {
        department.hide();
        }
}).trigger('init');
JS
)
?>