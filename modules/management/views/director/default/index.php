<?php
/* @var $this yii\web\View */

$this->title = 'Ваши задачи, как постановщика/помощника';
$this->params['breadcrumbs'][] = $this->title;

use backend\widgets\adminlte\components\AdminLTE;
use modules\management\models\Task;
use modules\management\widgets\InfoTaskWidget;
use modules\management\widgets\InfoTaskFullWidget;
use yii\helpers\Html;

?>

<div class="box">
    <div class="box-body box-primary">
        <div class="box-header">
            <?= Html::a('Новая задача', ['task/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= InfoTaskFullWidget::widget([
                    'colorBox' => AdminLTE::BG_GREEN,
                    'icon'=> 'tasks',
                    'overdue' => false,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
            <div class="col-md-6">
                <?= InfoTaskFullWidget::widget([
                    'colorBox' => AdminLTE::BG_PURPLE,
                    'icon'=> 'times-circle',
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
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
                    'colorBox' => AdminLTE::BG_GREEN,
                    'icon'=> 'plus',
                    'status' => Task::STATUS_NEW,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                    'icon'=> 'building',
                    'status' => Task::STATUS_WORK,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_TEAL,
                    'icon'=> 'check-square-o',
                    'status' => Task::STATUS_DONE,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'icon'=> 'hourglass-end',
                    'status' => Task::STATUS_ACCEPTED_TO_TIME,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="box box-danger">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE_ACTIVE,
                    'icon'=> 'pencil-square-o',
                    'status' => Task::STATUS_REWORK,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_ORANGE,
                    'icon'=> 'clock-o',
                    'status' => Task::STATUS_ACCEPTED_WITCH_OVERDUE,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_RED_ACTIVE,
                    'icon'=> 'minus-circle ',
                    'status' => Task::STATUS_NOT_EXECUTED,
                    'key' => 'director_user_id',
                    'link' => 'management-director'])
                ?>
            </div>
        </div>
    </div>
</div>

