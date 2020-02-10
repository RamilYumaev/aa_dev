<?php
use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictSchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $school dictionary\models\DictSchoolsReport*/

?>
<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'name',
                [  'format'=>'raw',
                    'value'=>function (\dictionary\models\DictSchools $model) use($school) {
                     if (!\dictionary\helpers\DictSchoolsReportHelper::isSchoolReport(
                         $model->dict_school_report_id, $model->id)) {
                     return  Html::a("Назначить", ['add-school-index', 'id' => $school->id, 'school_id' => $model->id],
                         ['class'=>'btn btn-success', 'data'=>['method' => 'post', 'confirm' => 'Вы уверены, что хотите 
                                 назначить учебную организацию главной?']]);
                     }
                     return "";
                }],
                ['format'=>'raw',
                    'value'=>function (\dictionary\models\DictSchools $model) use($school) {
                      if (!\dictionary\helpers\DictSchoolsReportHelper::isSchoolReport(
                         $model->dict_school_report_id, $model->id)) {
                     return  Html::a("Убрать", ['dictionary/dict-schools/reset-report', 'id'=> $model->id, 'school_id'=> $school->id],
                         ['class'=>'btn btn-danger', 'data'=>['method' => 'post', 'confirm' => 'Вы уверены, что хотите 
                                 убрать учебную организацию из чистовика?']]);
                      }
                        return "";
                }]
            ]
        ]); ?>
    </div>
</div>


