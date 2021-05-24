<?php
/* @var $this yii\web\View */
/* @var $isCreateTask  $bool */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

use backend\widgets\adminlte\components\AdminLTE;
use modules\management\models\Task;
use modules\management\widgets\InfoTaskFullWidget;
use modules\management\widgets\InfoTaskWidget;
use yii\helpers\Html; ?>

<div class="box">
    <div class="box-header">
        <?= Html::a('Новая задача', ['task/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Реестр документов', ['registry-document/index'], ['class' => 'btn btn-info']) ?>
        <?= $isCreateTask ? Html::a('Ваши задачи как постановщик/помощника', ['/management-director/default'], ['class' => 'btn btn-primary']) : ''?>
    </div>
    <div class="box-body box-primary">
        <div class="row">
            <div class="col-md-6">
                <?= InfoTaskFullWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'icon'=> 'tasks',
                    'overdue' => false,
                    'link' => 'management-user'])
                ?>
            </div>
            <div class="col-md-6">
                <?= InfoTaskFullWidget::widget([
                    'colorBox' => AdminLTE::BG_RED,
                    'icon'=> 'times-circle',
                    'link' => 'management-user'])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'icon'=> 'plus',
                    'status' => Task::STATUS_NEW,
                    'link' => 'management-user'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_BLUE,
                    'icon'=> 'building',
                    'status' => Task::STATUS_WORK,
                    'link' => 'management-user'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_ORANGE,
                    'icon'=> 'check-square-o',
                    'status' => Task::STATUS_DONE,
                    'link' => 'management-user'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_GREEN,
                    'icon'=> 'hourglass-end',
                    'status' => Task::STATUS_ACCEPTED_TO_TIME,
                    'link' => 'management-user'])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="box box-danger">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                    'icon'=> 'pencil-square-o',
                    'status' => Task::STATUS_REWORK,
                    'link' => 'management-user'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_YELLOW,
                    'icon'=> 'clock-o',
                    'status' => Task::STATUS_ACCEPTED_WITCH_OVERDUE,
                    'link' => 'management-user'])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_RED,
                    'icon'=> 'minus-circle ',
                    'status' => Task::STATUS_NOT_EXECUTED,
                    'link' => 'management-user'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_BLUE,
                    'icon'=> 'plus',
                    'status' => Task::STATUS_RESUMED,
                    'admin' => true,
                    'link' => 'management-user'])
                ?>
            </div>
        </div>
    </div>
</div>

