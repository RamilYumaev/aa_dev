<?php


use kartik\date\DatePicker;
use modules\entrant\helpers\SelectDataHelper;
use modules\management\models\DictTask;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\models\Task;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\TaskUserSearch*/

$string = $searchModel->overdue ? ($searchModel->overdue == 'no' ? ". Актуальные" : ". Просроченные") :"";
$this->title = 'Задачи'.$string;
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['task/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'afterRow' => function (Task $model, $index, $grid) {
                    return '<tr><td colspan="7">'.($model->isStatusNew() ? Html::a('Взять в работу', ['task/status', 'id' => $model->id, 'status' =>
                            Task::STATUS_WORK],['class'=> "btn btn-primary", 'data-confirm'=> "Вы уверены, что хотите взять в работу?"]) : "").
                        ($model->isStatusWork() || $model->isStatusRework() ? Html::a('Выполнено', ['task/status', 'id' => $model->id, 'status' =>
                            Task::STATUS_DONE],['class'=> "btn btn-success", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]) : "").'</td></tr>';
                },
                'columns' => [
                        ['class' => ActionColumn::class,
                        'controller' => "task",
                        'template' => '{view}',
                    ],
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'director_user_id',
                        'format' => "raw",
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, ManagementUser::find()->allColumn(),'director_user_id', 'directorProfile.fio'),
                        'value' => function($model) {
                            return $model->directorProfile->fio."<br />".$model->directorProfile->phone."<br />".$model->directorSchedule->email;
                        }],
                    'title',
                    ['attribute' => 'dict_task_id',
                        'format' => "raw",
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, DictTask::find()->allColumnUser($searchModel->userId),'dict_task_id', 'dictTask.name'),
                        'value' => function($model) {
                            return Html::tag('span', $model->dictTask->name, ['class' => 'label label-default',  'title' => $model->dictTask->description, 'style'=>['background-color'=> $model->dictTask->color]]);
                        }],
                    ['attribute' => 'status',
                        'format' => "raw",
                        'filter' => array_filter(array_combine(array_keys((new Task)->getStatusList()), array_column((new Task)->getStatusList(), 'name'))),
                        'value' => function($model) {
                            return Html::tag('span', $model->statusName, ['class' => 'label label-'.$model->statusColor]);
                        }],
                    'position',
                    ['attribute' => 'date_end',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '-',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ],
                        ]),
                        'format' => 'datetime',
                    ],
                    ['class' => ActionColumn::class,
                        'controller' => "task",
                        'template' => '{update}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
