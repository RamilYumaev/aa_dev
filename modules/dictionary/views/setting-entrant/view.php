<?php

use dictionary\helpers\DictSpecializationHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use modules\entrant\helpers\SelectDataHelper;
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

    <div class="box table-responsive">
        <div class="box-body">
            <?= \backend\widgets\adminlte\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'id',
                    ['attribute' => 'faculty_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, $searchModel->facultyList(),'faculty_id', 'faculty.full_name'),
                        'value' => 'faculty.full_name',
                    ],
                    ['attribute' => 'speciality_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel,$searchModel->specialityCodeList(),'speciality_id', 'specialty.codeWithName'),
                        'value' => 'specialty.codeWithName',
                    ],
                    ['attribute' => 'specialization_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel,$searchModel->specializationList(),'specialization_id', 'specialization.name'),
                        'value' => 'specialization.name'
                    ],

                    ['attribute' => 'edu_level',
                        'filter' => \dictionary\helpers\DictCompetitiveGroupHelper::getEduLevels(),
                        'value' => function ($model) {
                            return \dictionary\helpers\DictCompetitiveGroupHelper::eduLevelName($model->edu_level);
                        },
                    ],

                    ['attribute' => 'special_right_id',
                        'filter' => \dictionary\helpers\DictCompetitiveGroupHelper::getSpecialRight(),
                        'value' => function ($model) {
                            return \dictionary\helpers\DictCompetitiveGroupHelper::specialRightName($model->special_right_id);
                        },
                    ],
                    ['attribute' => 'education_form_id',
                        'filter' => $searchModel->educationFormList(),
                        'value' => function ($model) {
                            return \dictionary\helpers\DictCompetitiveGroupHelper::formName($model->education_form_id);
                        },
                    ],

                    ['attribute' => 'financing_type_id',
                        'filter' => $searchModel->financingTypeList(),
                        'value' => function ($model) {
                    return \dictionary\helpers\DictCompetitiveGroupHelper::financingTypeName($model->financing_type_id);
                        },
                    ],
                    'kcp',
                    'passing_score',
                    'competition_count',

                 'year',

                    ['class' => \yii\grid\ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>
</div>

