<?php

use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model modules\management\forms\DictTaskForm*/
/* @var $model modules\management\models\Schedule*/
$this->title = $model->profile->fio.". График работы" ;

$this->params['breadcrumbs'][] = ['label' => 'Графики работ', 'url' => ['schedule/index']];
$this->params['breadcrumbs'][] = $this->title;
$info = ['rateName', 'vacation:boolean', 'email', 'profile.phone',  [
    'label' => 'Должность',
    'value' => implode(', ', \modules\management\models\ManagementUser::find()->allColumnManagementUser($model->user_id)),
    'format' => 'raw',
]];
$even = [ 'monday_even', 'tuesday_even', 'wednesday_even', 'thursday_even', 'friday_even', 'saturday_even', 'sunday_even'];
$odd = [ 'monday_odd', 'tuesday_odd', 'wednesday_odd', 'thursday_odd', 'friday_odd', 'saturday_odd', 'sunday_odd'];
?>
<div class="row">
    <div class="col-md-4">
        <div class="box">
            <div class="box-header">
                <h4>Информация</h4>
            </div>
            <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $info,
            ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box">
            <div class="box-header">
                <h4>Нечетная неделя</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $odd,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box">
            <div class="box-header">
                <h4>Четная неделя</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $even,
                ]) ?>
            </div>
        </div>
    </div>
</div>            
