<?php


namespace modules\entrant\helpers;


class BlockRedGreenHelper
{

    const RED = 'bg-danger';
    const GREEN = 'bg-success';

    const TABLE_RED = 'danger';
    const TABLE_SUCCESS = 'success';
    const TABLE_WARNING = 'warning';


    public static function colorTableBg($countFile, $countValidate, $isTrue  = false) : string
    {
        if(!$countFile) {
            return self::TABLE_RED;
        }elseif ($countFile && ($countFile != $countValidate)) {
            return $isTrue ? self::TABLE_SUCCESS : self::TABLE_WARNING;
        } else {
            return self::TABLE_SUCCESS;
        }
    }



    public static function colorBg($bool) : string
    {
        return  $bool ? self::GREEN : self::RED;
    }


    public static function dataNoEmpty(array $array) {
        $i = 0;
        foreach (self::dataArray($array) as $value) {
            if (empty($value)) {
                $i++;
            }
        }
        return $i==0;
    }

    public static function dataArray($dataArray){
        $array = [];
        foreach ($dataArray as  $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }


}