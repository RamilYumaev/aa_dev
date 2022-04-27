<?php

use modules\dictionary\helpers\TestingEntrantDictHelper;
use modules\dictionary\models\TestingEntrant;
use modules\dictionary\models\TestingEntrantDict;
use modules\entrant\helpers\SelectDataHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\dictionary\searches\TestingEntrantDictSearch*/

$this->title = 'Мониторинг';
$this->params['breadcrumbs'][] = ['label' => 'Задачи для тестирования', 'url' => ['testing-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
$isDev = Yii::$app->user->can('dev') || Yii::$app->user->can('volunteering');
?>
<div class="box">
    <div class="box-body">
    </div>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'=> $searchModel,
            'afterRow' => function (TestingEntrantDict $model) use ($isDev) {
                return ($model->error_note ? '<tr class="danger"><td colspan="6"><div class="col-md-12">'.$model->error_note.'</div></td></tr>':'');
            },
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute'=>'id_dict_testing_entrant',  'filter' =>SelectDataHelper::dataSearchModel($searchModel, \modules\dictionary\models\DictTestingEntrant::find()->select('name')
                    ->indexBy('id')
                    ->orderBy(['name'=> SORT_ASC])
                    ->column(),'id_dict_testing_entrant', 'dctTestingEntrant.name'),  'value'=>'dctTestingEntrant.name'],
                ['attribute'=>'id_testing_entrant', 'filter'=> SelectDataHelper::dataSearchModel($searchModel, \modules\dictionary\models\TestingEntrant::find()->select('title')
                    ->indexBy('id')
                    ->orderBy(['title'=> SORT_ASC])
                    ->column(),'id_testing_entrant', 'testingEntrant.title'),'value'=>'testingEntrant.title'],
                ['attribute'=>'user_id',
                    'label' => 'Волонтер',
                   'filter' =>SelectDataHelper::dataSearchModel($searchModel, \olympic\helpers\auth\ProfileHelper::getVolunteering(),'user_id', 'testingEntrant.profile.fio'),
                  'value'=> function ($model) {  return $model->testingEntrant->user_id ? $model->testingEntrant->profile->fio.' '.$model->testingEntrant->profile->user->email : "";}],
                ['attribute' => 'status',
                    'format' => "raw",
                    'filter' => array_filter(array_combine(array_keys((new TestingEntrantDict())->getStatusList()),
                        array_column((new TestingEntrantDict())->getStatusList(), 'name'))),
                    'value' => function($model) {
                        return Html::tag('span', $model->statusName, ['class' => 'label label-'.$model->statusColor]);
                    }],
                'count_files',
                [
                    'format' => "raw",
                    'value' => function($model) {
                        return Html::a('Просмотр',['view', 'id'=>$model->id_testing_entrant,], ['class' => 'btn btn-info']);
                    }],
            ]
        ]); ?>
    </div>
</div>

