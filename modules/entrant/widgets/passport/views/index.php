<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="row">
    <div class="col-md-12">
        <h4>Паспортые данные</h4>
        <?= Html::a('Добавить', ['passport-data/create'], ['class' => 'btn btn-success']) ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'type',
                 'nationality',
                ['value'=> function (\modules\entrant\models\PassportData $model){
                     return $model->getPassportFull();
                },
                    'header' =>  "Паспортные данные"]
            ],
        ]) ?>
    </div>
</div>
