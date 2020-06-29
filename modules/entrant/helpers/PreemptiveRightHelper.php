<?php
namespace modules\entrant\helpers;
use modules\entrant\models\PreemptiveRight;
use yii\helpers\ArrayHelper;

class PreemptiveRightHelper
{
    const SUCCESS =1;
    const DANGER =2;

    public static function statusList() {
        return[
            self::SUCCESS =>"Принято",
            self::DANGER =>"Не принято",
            ];
    }

    public static function statusName($key) {
        return ArrayHelper::getValue(self::statusList(),$key);
    }

    public static function colorList() {
        return [
            self::SUCCESS =>"success",
            self::DANGER =>"danger",
            ];
    }

    public static function colorName($key) {
        return ArrayHelper::getValue(self::colorList(),$key);
    }
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

    public static function preemptiveRightMin($userId) {
        return PreemptiveRight::find()->joinWith('otherDocument')
            ->where(["user_id" => $userId,'statue_id'=> self::SUCCESS])
            ->select(['other_id'])
            ->min("type_id");
    }


}