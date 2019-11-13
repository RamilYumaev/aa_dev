<?php


namespace common\helpers;


class EduYearHelper
{
    public static function eduYear() : string
    {
        $date =  date("Y-m-d"); $year = date("Y");
        $dateStartEdu = $year."-09-01";
        $d = $year+1; $s = $year-1;
        if ($date > $dateStartEdu ) {
            return  $year."-".$d;
        } else {
            return  $s."-".$year;
        }
    }

    public  static function eduYearList(): array
    {
        $year = date("Y");
        $year = $year - 2;
        $result = [];
        for ($i = 1; $i <= 4; $i++) {
            $b = $year+$i;
            $a = $b+1;
            $eduYear= $b.'-'.$a;
            $result[$eduYear] = $eduYear;
        }
        return $result;
    }

}