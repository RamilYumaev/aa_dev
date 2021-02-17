<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\PostRateDepartmentSearch*/

$this->title = 'Сопоставление (отдел, должность, рабочая ставка)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['post-rate-department/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                     ['attribute'=>'dict_department_id',
                         'value'=> 'dictDepartment.name'],
                    ['attribute'=> 'post_management_id',
                        'value'=> 'postManagement.name'],
                    ['attribute'=> 'rate',
                        'value'=> 'rateName'],
                    ['class' => ActionColumn::class,
                        'controller' => "post-rate-department",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
