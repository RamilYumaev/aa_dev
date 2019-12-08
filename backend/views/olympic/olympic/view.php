<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\Olympic */

$this->title = "Просмотр";
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\modal\ModalAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
    <div class="box box-default">
        <div class="box box-header">
        <p>
            <?= Html::a('Обновить', ['update', 'id' => $olympic->id], ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal', 'class' => 'btn btn-primary']) ?>
        </p>
        </div>
        <div class="box-body">
    <?= DetailView::widget([
        'model' => $olympic,
        'attributes' => [
            'name',
            ['attribute' => 'status',
                'value' => \olympic\helpers\OlympicHelper::statusName($olympic->status)
                ]
        ],
    ]) ?>
        </div>
    </div>

<?= \backend\widgets\olimpic\OlipicListInOLymipViewWidget::widget(['model' => $olympic]) ?>

<?php if ($olympic->getOlympicOneLast() !== null && !$olympic->getOlympicOneLast()->isFormOfPassageInternal()): ?>

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('@backend/views/testing/question/_questions-type-link', ['olympic' => $olympic->id]) ?>
        </div>
        <div class="col-md-12">
            <?= \backend\widgets\testing\TestQuestionGroupWidget::widget(['model' => $olympic]) ?>
        </div>

    </div>
    </div>

<?php endif; ?>