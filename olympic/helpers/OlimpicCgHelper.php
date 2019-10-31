<?php


namespace olympic\helpers;


use olympic\models\OlimpicCg;


class OlimpicCgHelper
{
    public static function cgOlympicList($id) {
       return OlimpicCg::find()->select('competitive_group_id')->andWhere(['olimpic_id'=> $id])->column();
    }

}