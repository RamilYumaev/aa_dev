<?php
/* @var $this yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
/* @var $isBelarus $bool */
use yii\helpers\Html;
$this->title =  'Талоны';
\frontend\assets\modal\ModalAsset::register($this);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?=$this->title?></h1>
    <p>
        <?= Html::a("Добавить",
            ["add"], ["class" => "btn btn-primary",
                 'data-pjax' => 'w0', 'data-toggle' => 'modal',
                'data-target' => '#modal', 'data-modalTitle' => 'Добавить талон']) ?>
    </p>
    <div class="mt-20 table-responsive">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $provider,
            'columns' =>[
                ['class' => \yii\grid\SerialColumn::class],
                'name',
                'date:date'
            ],
        ]) ?>
    </div>
</div>


