<?php


namespace modules\entrant\helpers;


use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

class SelectDataHelper
{
    public static function dataSearchModel($model, $data, $searchAttribute, $value) {
        return Select2::widget([
            'model' => $model,
            'attribute' =>  $searchAttribute,
            'data' => $data,
            'value' => $value,
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'Выберите значение'
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'selectOnClose' => true,
            ]
        ]);
    }

}