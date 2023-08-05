<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones\model\CompetitiveGroupOnes */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones\forms\search\CompetitiveListSearch */

$this->title = "Конкурсная группа. Просмотр. " .$model->name;
$this->params['breadcrumbs'][] = ['label' => '"Конкурсные группы"', 'url' => ['default/index']];

$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= $model->file_name ? Html::a('Файл', ['default/file', 'id' => $model->id],
                ['class'=>'btn btn-info']) : "" ?>
        </div>
        <div class="box-body">
            <?= \yii\widgets\DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'education_level',
                    'education_form',
                    'department',
                    'speciality',
                    'profile',
                    'type_competitive',
                    'statusName',
                    'kcp_transfer',
                    'kcp'
                ],
            ]) ?>
        </div>
    </div>
</div>

<div>
    <div class="box">
        <div class="box-header">
            <h3>Конкурсные списки</h3>
        </div>
        <div class="box-body">
            <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'addButtons' => [],
                'rowOptions' => function(\modules\entrant\modules\ones\model\CompetitiveList $model){
                    if ($model::isOnOtherSuccess($model->snils_or_id, $model->id)) {
                        return ['class' => 'info'];
                    }
                    else {
                        return ['class' => 'default'];
                    }
                },
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                     'fio',
                     'snils_or_id',
                     'priority',
                     ['value' => 'subjectMarks', 'header' => 'Баллы за ВИ'],
                     'mark_ai',
                     'sum_ball',
                     ['value' => 'statusName',
                         'filter' => \modules\entrant\modules\ones\model\CompetitiveList::listStatuses(),
                          'attribute' => 'status'
                         ],
                    ['label' => "#",
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a('Просмотр', ['competitive-list/view',
                                'id' => $model->id,]);
                        }],
                    ['label' => "#",
                        'format' => 'raw',
                        'value' => function(\modules\entrant\modules\ones\model\CompetitiveList $model) {
                            if($model->status == $model::STATUS_SEMI_PASS) {
                                return  Html::a('Прошел', ['competitive-list/status',
                                    'id' => $model->id, 'status' => $model::STATUS_SUCCESS], ['data-confirm'=> "Вы уверенны, что хотичте это сделать?", 'class' => "btn btn-success"])  .'<br/>'.
                                    Html::a('Не прошел', ['competitive-list/status',
                                        'id' => $model->id, 'status' => $model::STATUS_NO_SUCCESS], ['data-confirm'=> "Вы уверенны, что хотичте это сделать?", 'class' => "btn btn-danger"]);
                            }
                            else if($model->status == $model::STATUS_SUCCESS) {
                                return  Html::a('Забрал заявление', ['competitive-list/status',
                                    'id' => $model->id, 'status' => $model::STATUS_RETURN], ['data-confirm'=> "Вы уверенны, что хотичте это сделать?", 'class' => "btn btn-info"]);
                            }else {
                                return $model::isOnOtherSuccess($model->snils_or_id, $model->id) ? "" :Html::a('Прошел', ['competitive-list/status',
                                    'id' => $model->id, 'status' => $model::STATUS_SUCCESS], ['data-confirm'=> "Вы уверенны, что хотичте это сделать?"]);
                            }
                        }],
                ],
                'actionColumnTemplate' => '',
            ]) ?>
        </div>
    </div>
</div>
