<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\literature\models\LiteratureOlympic */

$this->title = $model->user->profiles->fio;
$this->params['breadcrumbs'][] = ['label' => 'Участники ВОШ по литературе 2022', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="literature-olympic-view">
    <div class="box">
        <div class="box-header">
            <p>
                <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'user_id',
                    ['attribute'=> 'is_success',
                        'value' => $model->getSuccessName()],
                    'code',
                    'mark_end',
                    'code_two',
                    'mark_end_two',
                    'code_three',
                    'mark_end_three',
                    'mark_end_last',
                    ['attribute'=> 'status_last',
                        'value' => $model->getStatusUserName()],
                    'birthday:date',
                    'typeName',
                    'series',
                    'number',
                    'date_issue:date',
                    'authority',
                    'regionName',
                    'zone',
                    'city',
                    'full_name',
                    'short_name',
                    'statusName',
                    'mark_olympic',
                    'grade_number',
                    'gradeLetterName',
                    'grade_performs',
                    'fio_teacher',
                    'place_work',
                    'post',
                    'academicName',
                    'size',
                    'is_allergy:boolean',
                    'note_allergy:ntext',
                    'is_voz:boolean',
                    'is_need_conditions:boolean',
                    'note_conditions:ntext',
                    'note_special:ntext',
                    'date_arrival:datetime',
                    'typeTransportArrivalName',
                    'place_arrival',
                    'number_arrival',
                    'date_departure:datetime',
                    'typeTransportDepartureName',
                    'place_departure',
                    'number_departure',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>