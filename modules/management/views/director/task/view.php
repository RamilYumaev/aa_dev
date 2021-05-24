<?php

use backend\assets\modal\ModalAsset;
use modules\management\models\PostRateDepartment;
use modules\management\models\Task;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $task modules\management\models\Task*/
ModalAsset::register($this);
$this->title = $task->title;

$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['task/index']];
$this->params['breadcrumbs'][] = $this->title;
$director = [[ 'label' => 'ФИО','value' => $task->directorProfile->fio ], 'directorSchedule.email', 'directorProfile.phone',
    [
    'label' => 'Должность',
    'value' => implode(', ',  PostRateDepartment::find()->getAllColumnShortUser($task->director_user_id)),
    'format' => 'raw',
]];
$responsible = [[ 'label' => 'ФИО', 'value' => $task->responsibleProfile->fio],'responsibleSchedule.email', 'responsibleProfile.phone',  [
    'label' => 'Должность',
    'value' => implode(', ', PostRateDepartment::find()->getAllColumnUser($task->responsible_user_id)),
    'format' => 'raw',
]];

$taskData = ['title', 'dictTask.name',['value' => $task->dictTask->description, 'label' => 'Наименование функции сотрудника'],'statusName', 'date_end:datetime', 'position', 'note'];
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h4>Постановщик задачи</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $task,
                    'attributes' => $director,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box box-warning">
            <div class="box-header">
                <h4>Ответственный</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $task,
                    'attributes' => $responsible,
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header">
                <h4>Реестр документов</h4>
                <?= Html::a('Добавить документ', ['create-document', 'id' => $task->id], ['class'=> "btn btn-info"])?>
                <?= Html::a('Прикрепить документ', ['document-search', 'id' => $task->id], ['class'=> "btn btn-primary"])?>
            </div>
            <?= $this->render('_document',['task' => $task]) ?>
        </div>
        <div class="box box-info">
            <div class="box-header">
                <h4>Описание задачи</h4>
            </div>
            <div class="box-body">
                <?= $task->text ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-danger"">
            <div class="box-header">
                <h4>Задача</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $task,
                    'attributes' => $taskData,
                ]) ?>
            </div>
            <div class="box-footer">
                <?= ($task->isStatusDone() ? Html::a('Доработка', ['task/rework', 'id' => $task->id],['class'=> "btn btn-info btn-block",   'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина доработки']).
                    Html::a('Принято в срок', ['task/status', 'id' => $task->id, 'status' =>
                        Task::STATUS_ACCEPTED_TO_TIME],['class'=> "btn btn-success btn-block", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]).
                    Html::a('Принято не в срок', ['task/status', 'id' => $task->id, 'status' =>
                        Task::STATUS_ACCEPTED_WITCH_OVERDUE],['class'=> "btn btn-warning btn-block", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]).
                    Html::a('Не принято', ['task/status', 'id' => $task->id, 'status' =>
                        Task::STATUS_NOT_EXECUTED],['class'=> "btn btn-danger btn-block", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]) : "").
                 ($task->isStatusAcceptedToTime() ? Html::a('Возобновить', ['task/status', 'id' => $task->id, 'status' =>
                    Task::STATUS_RESUMED],['class'=> "btn btn-success btn-block", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]) : "")
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header">
                <h4>Комментарии</h4>
                <?= !$task->isStatusesAccepted() ? Html::a('Добавить комментарий', ['comment-task/create', 'id' => $task->id],['class'=> "btn btn-warning",   'data-pjax' => 'w5', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Добавить комментарий']) : ""?>
            </div>
            <div class="box-body">
                <?= $this->render('_comment',['task' => $task]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header">
                <h4>История</h4>
            </div>
            <div class="box-body">
                <?= $this->render('_history',['task' => $task]) ?>
            </div>
        </div>
    </div>
</div>



