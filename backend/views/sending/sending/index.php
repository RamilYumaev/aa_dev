<?php

use yii\helpers\Html;
use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\DictSendingUserCategoryHelper;
use common\sending\helpers\SendingHelper;
use common\helpers\DateTimeCpuHelper;
use backend\widgets\adminlte\grid\GridView;
$this->title = 'Рассылки';
$this->params['breadcrums'][] = $this->title;

\backend\assets\modal\ModalAsset::register($this);
?>
<div class="box box-default">
    <div class="box box-header">
        <? //Html::a('Добавить', ['create',],
            //['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                [
                    'attribute' => 'template_id',
                    'format' => 'raw',
                    'value' => function ($model)  {
                        return DictSendingTemplateHelper::templateName($model->template_id) .
                            ' (' .  DictSendingTemplateHelper::checkStatusTypeName($model->template_id).')';
                    }
                ],
//                [
//                    'attribute' => 'sending_category_id',
//                    'value' => function ($model) {
//                        return DictSendingUserCategoryHelper::categoryName($model->sending_category_id);
//                    }
//                ],
                [
                    'attribute' => 'status_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return SendingHelper::typeSendingName($model->status_id);

//                $result = $typeSending[$model->status_id];
//                if (Yii::$app->user->can('admin_faculty') && $model->status_id == Sending::WEITING_MODERATION) {
//                    $result .= '<br/>';
//                    $result .= Html::a('Запустить', '#', [
//                        'data-action' => 'post-request',
//                        'data-remote' => Url::toRoute(['start-sending', 'sendId' => $model->id]),
//                        'class' => 'btn btn-success',
//                    ]);
//
//                }
//                return $result;
                    }
                ],
                [   'label'=> 'Дата создания',
                    'attribute' => 'deadline',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return DateTimeCpuHelper::getDateChpu($model->deadline)
                            . ' в ' . DateTimeCpuHelper::getTimeChpu($model->deadline);
                    }
                ],
//                ['class' => \yii\grid\ActionColumn::class,
//                    'template' => '{update} {delete}',
//                    'buttons' => [
//                        'update' => function ($url,$model) {
//                            return Html::a(
//                                '<span class="glyphicon glyphicon-edit"></span>',
//                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal']);
//                        },
//                    ]
//                ],
            ],
        ]);?>
    </div>
</div>

