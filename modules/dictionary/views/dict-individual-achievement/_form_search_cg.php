<?php
use yii\helpers\Html;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\select2\Select2;
use dictionary\helpers\DictFacultyHelper;
?>
<hr/>
        <label>Уровень образования</label>
        <?= Html::dropDownList('', null,
            ['' => ''] + DictCompetitiveGroupHelper::getEduLevels(),
            ['id' => 'filter-education_level_id', 'class' => 'form-control']
        ) ?>
        <br/>

        <label>Форма обучения</label>
        <?= Html::dropDownList('', null,
            ['' => ''] + DictCompetitiveGroupHelper::getEduForms(),
            ['id' => 'filter-education_form_id', 'class' => 'form-control']
        ) ?>
        <br/>

<!--        <label>Вид финансирования</label>-->
<!--        --><?//= Html::dropDownList('', null,
//            ['' => ''] + DictCompetitiveGroupHelper::getFinancingTypes(),
//            ['id' => 'filter-financing_type_id', 'class' => 'form-control']
//        ) ?>
<!--        <br/>-->

        <label>Факультет</label>
        <?= Select2::widget([
            'name' => 'filter-faculty_id',
            'id' => 'filter-faculty_id',
            'data' =>DictFacultyHelper::facultyList(),
            'options' => ['placeholder' => 'Выберите факультет'],
            'pluginOptions' => ['allowClear' => true],
        ]); ?>
        <br/>
        <hr/>