<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\CgSSSearch */

$this->title = 'Конкурсные группы';
$this->params['breadcrumbs'][] = $this->title;
 ?>
<div>
    <div class="box">
        <div class="box-body table-responsive">
            <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'afterRow' =>function (\modules\entrant\modules\ones_2024\model\CgSS $model, $key, $index, $grid) {
                    return '<tr><td colspan="3">
                                           Абитуриенты СС: '.$model->getEntrantsApp()->count().'<br />
                                           Абитуриенты EPK: '.$model->getListCount().'<br />
                                           Абитуриенты CДО: '.$model->getListFokCount().'</td>'.
                            '</tr>';
                },
                 'addButtons' => [],
                'actionColumnTemplate' => '{update}',
                'columns' => [
                    ['class' => \yii\grid\ActionColumn::class, 'template' => '{view}'],
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    'education_level',
                    'education_form',
                    'code_spec',
                    'speciality',
                    'profile',
                    'type',
                    'kcp',
                    ['attribute'=> 'url',
                        'value' => function($model) {
                            return $model->url ? 'Да' : 'Нет';
                        }],
                    'datetime_url'
                    ]
            ]) ?>
        </div>
    </div>
</div>
