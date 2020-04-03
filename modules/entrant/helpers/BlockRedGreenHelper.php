<?php


namespace modules\entrant\helpers;


class BlockRedGreenHelper
{

    const RED = 'bg-danger';
    const GREEN = 'bg-success';

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