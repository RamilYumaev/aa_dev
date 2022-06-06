<?php
use yii\helpers\Html;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\select2\Select2;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
?>
<hr/>
        <label>Уровень образования</label>
        <?= Html::dropDownList('', null,
            ['' => ''] + DictCompetitiveGroupHelper::getEduLevels(),
            ['id' => 'filter-education_level_id', 'class' => 'form-control']
        ) ?>
        <br/>

        <label>Форма обучения</label>
        <?= Select2::widget([
            'name' => 'filter-education_form_id',
            'id' => 'filter-education_form_id',
            'data' =>DictCompetitiveGroupHelper::getEduForms(),
            'options' => ['placeholder' => 'Выберите форму обучения', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
        ]); ?>
       <br/>
        <label>Вид финасирования</label>
        <?= Select2::widget([
            'name' => 'filter-finance_id',
            'id' => 'filter-finance_id',
            'data' => DictCompetitiveGroupHelper::getFinancingTypes(),
            'options' => ['placeholder' => 'Выберите вид финансирования', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
        ]); ?>
        <br/>
        <label>Факультет</label>
        <?= Select2::widget([
            'name' => 'filter-faculty_id',
            'id' => 'filter-faculty_id',
            'data' =>DictFacultyHelper::facultyList(),
            'options' => ['placeholder' => 'Выберите факультет', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
        ]); ?>
        <br/>
        <label>Направления подготовки</label>
        <?= Select2::widget([
            'name' => 'filter-speciality_id',
            'id' => 'filter-speciality_id',
            'data' =>DictSpecialityHelper::specialityNameAndCodeList(),
            'options' => ['placeholder' => 'Выберите направление', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
        ]); ?>
        <br/>

        <hr/>