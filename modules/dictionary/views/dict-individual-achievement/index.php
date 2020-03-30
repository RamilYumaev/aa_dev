<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use modules\dictionary\helpers\DictDefaultHelper;

/* @var $this yii\web\View */
/* @var $searchModel modules\dictionary\searches\DictIndividualAchievementSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Индивидуальные достижения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Cоздать', ['dict-individual-achievement/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    'name_short',
                    'mark',
                    ['attribute'=> 'category_id', 'filter'=> DictDefaultHelper::categoryDictIAList(), 'value'=>'category'],
                    'year',
                    ['class' => ActionColumn::class,
                        'controller' => "dict-individual-achievement",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
