<?php

use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use yii\grid\ActionColumn;

?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?= Html::a('Создать', ['create', 'olympic_id' => $olympic_id], ['class' => 'btn btn-success']); ?>
            </div>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => \yii\grid\SerialColumn::class],
                        'title',
                        'text:raw',
                        ['class' => ActionColumn::class,
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open">', ['view',
                                        'id' => $model->id, 'olympic_id' => $model->olympic_id]);
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash">', ['delete',
                                        'id' => $model->id, 'olympic_id' => $model->olympic_id]);
                                }
                            ]]]]); ?>
            </div>
        </div>
    </div>
</div>