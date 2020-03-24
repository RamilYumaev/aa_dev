<?php

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictDisciplineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дисциплины';
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
                    'name',
                    ['attribute'=> 'cse_subject_id', 'value'=> 'cseSubject'],
                    ['class' => ActionColumn::class,
                        'template'=>'{update} {delete}'],
                ]
            ]); ?>
        </div>
    </div>
</div>
