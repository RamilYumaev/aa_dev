<?php

use dictionary\helpers\DictSpecializationHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\SelectDataHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictCompetitiveGroupSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model modules\dictionary\models\SettingEntrant */

$this->title = 'Настройки приема. Конкурсные группы ' . $model->string;
$this->params['breadcrumbs'][] = ['label' => 'Настройки приема', 'url' => ['setting-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-coml-group-index">

    <div class="box table-responsive">
        <div class="box-body">
            <?= \backend\widgets\adminlte\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    $model->edu_level == \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL ?
                        [
                            'value' => function ($cg) use ($model){
                                return implode(',', DictCompetitiveGroup::find()
                                    ->formEdu($model->form_edu)
                                    ->finance($model->finance_edu)
                                    ->eduLevel($model->edu_level)
                                    ->specialRight($model->special_right)
                                    ->foreignerStatus($model->foreign_status)
                                    ->tpgu($model->tpgu_status)
                                    ->speciality($cg->speciality_id)
                                    ->faculty($cg->faculty_id)
                                    ->select('ais_id')
                                    ->column());
                            },
                            'format' => 'raw'
                        ]
                        :'id' ,

                    [
                        'value' => function ($cg) use ($model){
                            return $cg->ais_id && !$cg->tpgu_status && !$cg->foreigner_status ? Html::a('Обновить КС', ['send-cg', 'id' => $cg->id], ['class'=>'btn btn-warning',
                                'data'=>['confirm'=> 'Вы уверены, что хотите это сделать?']]) :'';
                        },
                        'format' => 'raw'
                    ],
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

                ]
            ]); ?>
        </div>
    </div>
</div>

