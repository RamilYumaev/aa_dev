<?php
/* @var $model modules\transfer\search\CompetitiveGroupSearch */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>

<?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>
      <?= $form->field($model, 'year')->dropDownList($model->getYears())->label('Год поступления') ?>
      <?= $form->field($model, 'edu_level')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getEduLevels()) ?>
      <?= $form->field($model, 'education_form_id')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getEduForms()) ?>
      <?= !$model->getStatusFinance() ? $form->field($model, 'financing_type_id')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::listFinances()) : ''?>
      <?= $form->field($model, 'faculty_id')->widget(\kartik\select2\Select2::class,[
        'name' => 'filter-faculty_id',
        'id' => 'filter-faculty_id',
        'data' =>$model->facultyList(),
        'options' => ['placeholder' => 'Выберите факультет'],
        'pluginOptions' => ['allowClear' => true]]
        ) ?>
      <?= $form->field($model, 'speciality_id')->widget(\kartik\select2\Select2::class,[
        'name' => 'filter-speciality_id',
        'id' => 'filter-speciality_id',
        'data' =>$model->specialityCodeList(),
        'options' => ['placeholder' => 'Выберите'],
        'pluginOptions' => ['allowClear' => true]]) ?>
      <?= $form->field($model, 'specialization_id')->widget(\kartik\select2\Select2::class,[
            'name' => 'filter-specialization_id',
            'id' => 'filter-specialization_id',
            'data' =>$model->specializationList(),
            'options' => ['placeholder' => 'Выберите'],
           'pluginOptions' => ['allowClear' => true]]) ?>
    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>