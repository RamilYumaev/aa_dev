<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\TemplatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны';
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
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['attribute' => 'type_id',
                        'filter' => $searchModel->typeTemplatesList(),
                        'value' => function ($model) {
                            return \dictionary\helpers\TemplatesHelper::typeTemplateName($model->type_id);
                        },
                    ],
                    ['class' => ActionColumn::class,
                        'template'=>'{update} {delete}'],
                ]
            ]); ?>
        </div>
    </div>
</div>

