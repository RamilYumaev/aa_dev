<?php
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\sending\forms\SendingCreateForm | common\sending\forms\SendingEditForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'sending_category_id')->widget(Select2::class, [
    'data' => $model->sendingUserCategoryList(),
    'options' => ['placeholder' => 'Выберите категорию'],
    'pluginOptions' => [
        'allowClear' => true,
    ],

]); ?>
<?= $form->field($model, 'template_id')->widget(Select2::class, [
    'data' => $model->sendingTemplateList(),
    'options' => ['placeholder' => 'Выберите шаблон'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]); ?>

<?= $form->field($model, 'deadline')->widget(DateTimePicker::class, [
    'options' => ['placeholder' => 'Введите дату и время ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy.mm.dd hh:ii',
        'startDate' => "+1d",
    ],
]); ?>
