<?php

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictSpecialitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Направления подготовки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => SerialColumn::class],
                    'code',
                    'name',
                    'short',
                    ['attribute'=>'edu_level',
                      'filter' => \dictionary\helpers\DictCompetitiveGroupHelper::getEduLevelsAbbreviated(),
                        'value'=> function($model) {
                            return \dictionary\helpers\DictCompetitiveGroupHelper::getEduLevelsAbbreviated()[$model->edu_level];
                        }],
                    'series',
                    'number',
                    'date_begin:date',
                    'date_end:date',
                    ['class' => ActionColumn::class,
                        'template'=>'{update} {delete}'],
                ]
            ]); ?>
        </div>
    </div>
</div>
