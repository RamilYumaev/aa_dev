<?php

use yii\helpers\Html;
use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\DictSendingUserCategoryHelper;
use common\sending\helpers\SendingHelper;
use common\helpers\DateTimeCpuHelper;
use backend\widgets\adminlte\grid\GridView;
$this->title = 'Категории польователей (Рассылки)';
$this->params['breadcrums'][] = $this->title;

\backend\assets\modal\ModalAsset::register($this);
?>
<div class="box box-default">
    <div class="box box-header">
        <?=Html::a('Добавить', ['create',],
            ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal']);
                        },
                    ]
                ],
            ],
        ]);?>
    </div>
</div>

