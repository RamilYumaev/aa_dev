<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;
use modules\entrant\helpers\DocumentEducationHelper;
use modules\entrant\helpers\OtherDocumentHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer */
?>
<?php Box::begin(
    [
        "header" => "Прочие документы",
        "type" => Box::TYPE_PRIMARY,
        "filled" => true,]) ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'type', 'value' =>'typeName'],
                ['value'=> 'otherDocumentFull', 'header' =>  "Данные"],
                ['value'=> 'noteOrTypeNote', 'header' =>  "Примечание"],
            ],
        ]) ?>
<?php Box::end();


