<?php

use dictionary\helpers\DictSpecializationHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictCompetitiveGroupSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Конкурсные группы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-coml-group-index">

    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= \backend\widgets\adminlte\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'speciality_id',
                        'filter' => $searchModel->specialityCodeList(),
                        'value' => function ($model) {
                            return DictSpecialityHelper::specialityCodeName($model->speciality_id);
                        },
                    ],
                    ['attribute' => 'specialization_id',
                        'filter' => $searchModel->specializationList(),
                        'value' => function ($model) {
                            return DictSpecializationHelper::specializationName($model->specialization_id);
                        },
                    ],

                    ['attribute' => 'education_form_id',
                        'filter' => $searchModel->educationFormList(),
                        'value' => function ($model) {
                            return \dictionary\helpers\DictCompetitiveGroupHelper::formName($model->education_form_id);
                        },
                    ],
                    ['attribute' => 'faculty_id',
                        'filter' => $searchModel->facultyList(),
                        'value' => function ($model) {
                            return DictFacultyHelper::facultyName($model->faculty_id);
                        },
                    ],
                    ['attribute' => 'financing_type_id',
                        'filter' => $searchModel->financingTypeList(),
                        'value' => function ($model) {
                    return \dictionary\helpers\DictCompetitiveGroupHelper::financingTypeName($model->financing_type_id);
                        },
                    ],

                 'year',

                    ['class' => \yii\grid\ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>
</div>

