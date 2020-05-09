<?php
namespace modules\entrant\helpers;
use modules\entrant\models\PreemptiveRight;

class PreemptiveRightHelper
{
    public static function  allOtherDoc($userId) {
       $model = PreemptiveRight::find()->joinWith('otherDocument')
            ->where(["user_id" => $userId])
            ->select(['other_id'])
            ->groupBy(['other_id'])->all();
       $result = "";
       foreach($model as $item) {
           $result.= $item->otherDocument->typeName." ".($item->otherDocument->series ?? "" ). " №".$item->otherDocument->number.", ";
       }
       return $result ? rtrim($result, ", ") . "." : "";
    }

}