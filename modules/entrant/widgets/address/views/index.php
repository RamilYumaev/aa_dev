<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12">
        <h4>Контактная информация</h4>
        <?= Html::a('Добавить', ['address/create'], ['class' => 'btn btn-success']) ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'type',
                 'country_id',
                ['value'=> function (\modules\entrant\models\Address $model){
                     return $model->getAddersFull();
                },
                    'header' =>  "Адрес"]
            ],
        ]) ?>
    </div>
</div>
