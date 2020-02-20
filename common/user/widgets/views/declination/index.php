<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\auth\models\DeclinationFio */
\teacher\assets\modal\ModalAsset::register($this);
?>
<div class="box">
    <div class="box-header">
        <h4>Склонение ФИО</h4>
        <?=  Html::a( "Редактировать",
            ['declination/update', 'id' => $model->id], ['data-pjax' => 'w0',
                'data-toggle' => 'modal', 'class'=>'btn btn-primary pull-right',
                'data-modalTitle' =>'Редактирование',
                'data-target' => '#modal']) ?>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'nominative',
                'genitive',
                'dative',
                'accusative',
                'ablative',
                'prepositional',
            ],
        ]) ?>
    </div>
</div>

