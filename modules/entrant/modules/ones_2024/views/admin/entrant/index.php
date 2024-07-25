<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\EntrantSearch */

use yii\helpers\Html;

$this->title = 'Абитуриенты';
$this->params['breadcrumbs'][] = $this->title;
 ?>
<div>
    <div class="box">
        <div class="box-body table-responsive">
            <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'addButtons' => [],
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    "fio",
                    "snils",
                    "sex",
                    'nationality',
                    'email',
                    'phone',
                    'is_hostel:boolean',
                    ['label' => "#",
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a('Просмотр', ['view',
                                'id' => $model->id,]);
                        }],
                ],
                'actionColumnTemplate' => '',
            ]) ?>
        </div>
    </div>
</div>
