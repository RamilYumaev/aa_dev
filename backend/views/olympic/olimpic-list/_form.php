<?php
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $olympic olympic\models\OlimpicList */
/* @var $model olympic\forms\OlimpicListCopyForm */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="box box-default">
    <div class="box-header">
        <?= Html::a('Вернуться', ['olympic/olympic/view', 'id' => $olympic_id], ['class' => 'btn btn-info']) ?>
    </div>
    <div class="box-body">
<?= $form->field($model, 'year')->dropDownList($model->years()) ?>

<?= $form->field($model, 'prefilling')->dropDownList($model->prefilling()) ?>

<?= $form->field($model, 'chairman_id')->dropDownList($model->chairmansFullNameList(), ['prompt' => 'Выберите председателя оргкоммитета'
]) ?>

<?= $form->field($model, 'faculty_id')->dropDownList($model->facultyList(), ['prompt'=> 'Учредитель мероприятия']) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'genitive_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'content')->widget(CKEditor::class, [
    'editorOptions' =>  ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
]); ?>

<?= $form->field($model, 'promotion_text')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'date_range')->widget(\kartik\daterange\DateRangePicker::class, [
    'convertFormat'=>true,
    'pluginOptions'=>[
        "timePicker"=> true,
        "timePicker24Hour"=> true,
        'timePickerIncrement'=>1,
        'locale'=>['format'=>'Y-m-d H:i:s']
    ]
])?>

<?= $form->field($model, 'required_documents')->textarea(['row' => 6]) ?>

<?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'edu_level_olymp')->dropDownList($model->levelOlimp()) ?>

<?= $form->field($model, 'list_position')->dropDownList($model->listPosition()) ?>



<?= $form->field($model, 'only_mpgu_students')->checkbox(); ?>

        <?= $form->field($model, 'cg_no_visible')->checkbox(); ?>

<?= $form->field($model, 'competitiveGroupsList')->widget(Select2::class, [
    'options' => ['placeholder' => 'Выберите конкурсные группы', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= $form->field($model, 'classesList')->widget(Select2::class, [
    'options' => ['placeholder' => 'Выберите классы и курсы', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= $form->field($model, 'number_of_tours')->dropDownList($model->numberOfTours()) ?>

<?= $form->field($model, 'form_of_passage')->dropDownList($model->formOfPassage()) ?>

<?= $form->field($model, 'time_of_distants_tour_type')->dropDownList($model->typeOfTimeDistanceTour()); ?>

<?= $form->field($model, 'time_of_distants_tour')->textInput(['type' => 'number']) ?>


<?php echo $form->field($model, 'date_time_start_tour')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Введите дату и время ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy.mm.dd hh:ii'
    ]
]);
?>

<?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'time_of_tour')->textInput() ?>

<?= $form->field($model, 'requiment_to_work_of_distance_tour')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
]); ?>

<?= $form->field($model, 'requiment_to_work')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash'])
]); ?>


<?= $form->field($model, 'criteria_for_evaluating_dt')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash'])
]); ?>

<?= $form->field($model, 'criteria_for_evaluating')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash'])
]); ?>


<?= $form->field($model, 'showing_works_and_appeal')->dropDownList($model->showingWork()); ?>

<?= $form->field($model, 'certificate_id')->checkbox(); ?>
        
        <?= $form->field($model, 'percent_to_calculate')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
    </div>
</div>
