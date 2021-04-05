<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\dictionary\searches\SettingEntrantSearch */


$this->title = 'Настройки приема';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['setting-entrant/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute'=>'faculty_id', 'filter' => \dictionary\helpers\DictFacultyHelper::facultyListSetting(), 'value'=>'faculty'],
                    ['attribute'=>'form_edu', 'filter'=> DictCompetitiveGroupHelper::getEduForms(),'value'=>'formEdu'],
                    ['attribute'=>'edu_level', 'filter'=> DictCompetitiveGroupHelper::getEduLevelsAbbreviated(), 'value'=>'eduLevel'],
                    ['attribute'=>'special_right', 'filter'=> DictCompetitiveGroupHelper::getSpecialRight(), 'value'=>'specialRight'],
                    ['attribute'=>'finance_edu', 'filter' => DictCompetitiveGroupHelper::listFinances(), 'value'=>'financeEdu'],
                    ['attribute'=>'type', 'filter'=> (new \modules\dictionary\models\SettingEntrant())->getTypeList(), 'value'=>'typeName'],
                    ['attribute'=>'is_vi', 'filter'=> ['Нет', 'Да'], 'value'=> 'is_vi', 'format' => 'boolean'],
                    ['attribute'=>'cse_as_vi', 'filter'=> ['Нет', 'Да'], 'value'=> 'cse_as_vi', 'format' => 'boolean'],
                    ['attribute'=>'foreign_status', 'filter'=> ['Нет', 'Да'], 'value'=> 'foreign_status', 'format' => 'boolean'],
                    ['attribute'=>'tpgu_status', 'filter'=> ['Нет', 'Да'], 'value'=> 'tpgu_status', 'format' => 'boolean'],
                    'datetime_start:datetime',
                    'datetime_end:datetime',
                    ['class' => ActionColumn::class,
                        'controller' => "setting-entrant",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
