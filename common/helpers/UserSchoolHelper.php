<?php


namespace common\helpers;


class UserSchoolHelper
{
    public static function eduYear() : string
    {
        $date =  date("Y-m-d"); $year = date("Y");
        $dateStartEdu = $year."-09-01";
        $d = $year+1; $s = $year-1;
        if ($date > $dateStartEdu ) {
            return  $year."/".$d;
        } else {
            return  $s."/".$year;
        }
    }

}