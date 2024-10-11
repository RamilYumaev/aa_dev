<?php

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\helpers\SendingHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\OlimpicList/ */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Тесты</h4>
        <?php if ($olympic->olympicSpecialityOlimpicList && $dataProvider->count) : ?>
            <?php if ($olympic->isFormOfPassageDistant() || $olympic->isFormOfPassageDistantDistant()): ?>
                <?php if ($olympic->isDistanceFinish()): ?>
                    <?php if ($olympic->year == \common\helpers\EduYearHelper::eduYear()) : ?>
                        <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                            SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA, $olympic->id) ? Html::a("Запустить рассылку писем с дипломами",
                            ['olympic/olympic-delivery-status/send-diploma', 'olympic_id' => $olympic->id], ['class' => 'btn btn-info']) :
                            Html::a("Просмотр состояния рассылки (дипломы/сертификаты)",
                                ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                                    'typeSending' => SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA], ['class' => 'btn btn-info']) ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?= Html::a("Завершить заочный тур", ['testing/test-attempt/end-dist-tour-all', 'olympic_id' => $olympic->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Вы уверены, что хотите это сделать?']) ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?=Html::a('Добавить', ['testing/test/create','olympic_id' => $olympic->id],
            ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['label'=>"Классы(курсы)",
                    'value' => function($model) {
                        return \testing\helpers\TestClassHelper::TestClassString($model->id);
                    }],
                'olympicSpecialityProfile.name',
                [
                    'value' => function($model) {
                        return (!$model->status ?
                            Html::a('Запустить тест',['testing/test/start', 'id' => $model->id],  ['class'=>'btn btn-success']) :
                            Html::a('Остановить тест',['testing/test/end', 'id' => $model->id],  ['class'=>'btn btn-danger'])).
                            Html::a("Пробный тест", ['trail-attempt/start',
                                'test_id'=> $model->id],
                                ['data' => ['confirm' => 'Вы действительно хотите начать пробный тест ?', 'method' => 'POST'],
                                    'class' =>'btn btn-primary']);
                    }, "format" => "raw"],
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update} {view} {delete}',
                    'controller' => 'testing/test',
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal']);
                        },
                    ]
                ],
            ],
        ]) ?>
    </div>
</div>

