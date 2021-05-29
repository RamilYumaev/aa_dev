<?php

namespace modules\dictionary\helpers;

use modules\dictionary\models\DictCathedra;
use modules\dictionary\models\TestingEntrantDict;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TestingEntrantDictHelper
{
    public static function link($status, TestingEntrantDict $model): string
    {
        $array = $model->getStatusList();
         return  Html::a($array[$status]['name'], ["testing-entrant/status-task", 'id' => $model->id_testing_entrant,
             'dict'=>$model->id_dict_testing_entrant , 'status' => $status],
             ["class" => "btn btn-".$array[$status]['color']]);
    }


}