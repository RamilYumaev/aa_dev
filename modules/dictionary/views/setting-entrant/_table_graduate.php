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
        [
            'value' => function ($cg) use ($model){
              $data = implode(',', DictCompetitiveGroup::find()
                    ->formEdu($model->form_edu)
                    ->finance($model->finance_edu)
                    ->eduLevel($model->edu_level)
                    ->specialRight($model->special_right)
                    ->foreignerStatus($model->foreign_status)
                    ->tpgu($model->tpgu_status)
                    ->speciality($cg->speciality_id)
                    ->faculty($cg->faculty_id)
                    ->currentAutoYear()
                    ->select('ais_id')
                  ->andWhere(['not', ['ais_id' => null]])
                    ->column());
              return $data . ($data ? Html::a('Обновить КС', ['send-cg-graduate', 'id' => $data, 'se'=> $model->id, 'faculty'=> $cg->faculty_id,
                      'speciality'=>$cg->speciality_id], ['class'=>'btn btn-warning pull-right',
                  'data'=>['confirm'=> 'Вы уверены, что хотите это сделать?']]) :'');
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

    ]
]);
?>
