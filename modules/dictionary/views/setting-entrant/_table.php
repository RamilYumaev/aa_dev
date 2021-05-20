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

?>
<?= \backend\widgets\adminlte\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
        'id' ,
        [
            'value' => function ($model){
                return $model->ais_id && !$model->tpgu_status && !$model->foreigner_status ? Html::a('Обновить КС', ['send-cg', 'id' => $model->id], ['class'=>'btn btn-warning',
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

