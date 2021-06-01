<?php

use modules\dictionary\helpers\TestingEntrantDictHelper;
use modules\dictionary\models\TestingEntrantDict;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);
/* @var $this yii\web\View */
/* @var $testing modules\dictionary\models\TestingEntrant */
$isDev = Yii::$app->user->can('dev') || Yii::$app->user->can('volunteering');
$this->title = 'Просмотр задачи';
$this->params['breadcrumbs'][] = ['label' => 'Задачи для тестирования', 'url' => ['testing-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-view">
    <div class="box">
        <div class="box-header">
            <h4>Данные</h4>
            <?php if($isDev): ?>
                <?=   Html::a($testing->isStatusOpen() ? "Закрыть":"Открыть", ['testing-entrant/status', 'id' => $testing->id,
                    'status' => $testing->isStatusOpen() ? true: false], ['class' => 'btn btn-success'])?>
            <?php endif; ?>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $testing,
                'attributes' => [
                    'title',
                    'fio',
                    ['label' => $testing->getAttributeLabel('department'),
                        'value' => $testing->departmentString,
                    ],
                    ['label' => $testing->getAttributeLabel('special_right'),
                        'value' => $testing->specialRight,
                    ],
                    ['label' => $testing->getAttributeLabel('edu_level'),
                        'value' => $testing->eduLevel,
                    ],
                    ['label' => $testing->getAttributeLabel('edu_document'),
                        'value' => $testing->edu_document ? \modules\entrant\helpers\AnketaHelper::currentEducationLevel()[$testing->edu_document] : "",
                    ],
                    ['label' => $testing->getAttributeLabel('country'),
                        'value' => $testing->country ? \dictionary\helpers\DictCountryHelper::countryName($testing->country) : "",
                    ],
                    ['label' => $testing->getAttributeLabel('category'),
                        'value' => $testing->category ? \modules\entrant\helpers\CategoryStruct::labelLists()[$testing->category] : "",
                    ],
                    ['label' => $testing->getAttributeLabel('user_id'),
                        'value' => $testing->user_id ? $testing->profile->fio : "",
                    ],
                    ['label' => $testing->getAttributeLabel('status'),
                        'value' => $testing->statusName
                    ],
                    'note:raw'
                ],
            ]) ?>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-header">
        <h4>Подзадачи</h4>
        <?php if($isDev): ?>
        <?= Html::a('Добавить подзаадчу', ['testing-entrant/add-task','id'=>$testing->id, ], ['class' => 'btn btn-success', 'data-pjax' => 'w2', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => '']) ?>
        <?php endif; ?>
    </div>
    <div class="box-body">
        <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => new ActiveDataProvider(['query' => $testing->getTestingEntrantDict()]),
            'afterRow' => function (TestingEntrantDict $model) use ($isDev) {

                    return '<tr><td colspan="3">'. (!$model->isStatusError() || !$model->isStatusFix() ? TestingEntrantDictHelper::link($model::STATUS_WORK, $model).
                            TestingEntrantDictHelper::link($model::STATUS_SUCCESS, $model):"").
                        ($isDev && $model->isStatusError()  ? TestingEntrantDictHelper::link($model::STATUS_FIX, $model) :'').
                        Html::a("Ошибка", ["testing-entrant/message", 'id' => $model->id_testing_entrant,
                            'dict'=> $model->id_dict_testing_entrant],
                            ["class" => "btn btn-danger",
                                'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => '']).'</td>
                        <td colspan="1">'.Html::tag('span', $model->statusName, ['class' => 'label label-' . $model->statusColor]).'</td>
                            <tr/>'.($model->error_note ? '<tr class="danger"><td colspan="5">'.$model->error_note.'</td></tr>':'').
                        ($model->count_files ? '<tr class="info"><td colspan="5">'.\modules\dictionary\helpers\TestingEntrantHelper::images($model).'</td></tr>':'');
                    },
            'columns' => [
            ['class' => \yii\grid\SerialColumn::class],
                'dctTestingEntrant.name',
                'dctTestingEntrant.description:raw',
                'dctTestingEntrant.result:raw',
            ]
        ]); ?>
        </div>
    </div>
</div>
