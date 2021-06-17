<?php

/* @var $this yii\web\View */
/* @var $task  \modules\management\models\Task */

$this->title = "Добавление нового документа к задаче";
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['task/index']];
$this->params['breadcrumbs'][] = ['label' => $task->title, 'url' => ['task/view', 'id' => $task->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@modules/management/views/admin/registry-document/_form', ['model'=> $model] )?>
