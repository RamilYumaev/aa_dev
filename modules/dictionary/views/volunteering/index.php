<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\VolunteeringSearch */


$this->title = 'Волонтеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a("Данные Excel",['export'], ['class'=> 'btn btn-success']) ?>
        </div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => ActionColumn::class,
                        'controller' => "volunteering",
                        'template' => '{update}',
                    ],
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute'=>'job_entrant_id',
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, \modules\dictionary\models\Volunteering::find()->allColumn(),'job_entrant_id', 'ntrantJob.profileUser.fio'),
                        'value'=>'entrantJob.profileUser.fio'],
                    ['attribute'=>'faculty_id',
                        'filter' => \dictionary\helpers\DictFacultyHelper::facultyList(),
                        'value'=>'faculty.full_name'],
                    ['attribute'=>'form_edu', 'filter'=> DictCompetitiveGroupHelper::getEduForms(),'value'=>'formEdu'],
                    ['attribute'=>'course_edu', 'filter'=> \dictionary\helpers\DictClassHelper::getListMPSU(), 'value'=>'course.classFullName'],
                    ['attribute'=>'finance_edu', 'filter' => DictCompetitiveGroupHelper::listFinances(),
                        'value'=>'financeEdu'],
                    'number_edu',
                    ['attribute'=>'clothes_size', 'filter'=> (new \modules\dictionary\models\Volunteering())->listClothesSize(), 'value'=>'clothesSize'],
                    ['attribute'=>'clothes_type',   'filter'=> \olympic\helpers\auth\ProfileHelper::typeOfGender(),
                    'value'=>'clothesType'],
                    ['attribute'=>'desire_work', 'filter'=>  \modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories(),
                        'value'=>'desireWork'],
                    ['attribute'=>'experience', 'filter'=> ['Нет', 'Да'],
                        'value'=> 'experience', 'format' => 'boolean'],
                    ['attribute'=>'is_reception', 'filter'=> ['Нет', 'Да'],
                        'value'=> 'is_reception', 'format' => 'boolean'],
                ]
            ]); ?>
        </div>
    </div>
</div>
