<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12">
        <h4>Адреса регистрации и проживания:</h4>
        <?= Html::a('Добавить', ['address/create'], ['class' => 'btn btn-success mb-10']) ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'type',
                    'value' => function (\modules\entrant\models\Address $model) {
                        return $model->typeName;
                    },],
                ['attribute'=>'country_id',
                    'value' => function (\modules\entrant\models\Address $model) {
                        return $model->countryName;
                    },],

                ['value'=> function (\modules\entrant\models\Address $model){
                     return $model->getAddersFull();
                },
                    'header' =>  "Адрес"],
                ['class'=> \yii\grid\ActionColumn::class, 'controller' => 'address', 'template'=> '{update}{delete}']
            ],
        ]) ?>
    </div>
</div>
