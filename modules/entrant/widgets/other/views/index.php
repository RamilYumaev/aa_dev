<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12">
        <h4>Прочие документы</h4>
        <?= Html::a('Добавить', ['other-document/create'], ['class' => 'btn btn-success']) ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'type', 'value' =>'typeName'],
                ['value'=> 'otherDocumentFull', 'header' =>  "Данные"],
                'note',
                ['class'=> \yii\grid\ActionColumn::class, 'controller' => 'other-document', 'template'=> '{update}{delete}']
            ],
        ]) ?>
    </div>
</div>
