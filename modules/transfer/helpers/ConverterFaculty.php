<?php


namespace modules\transfer\helpers;


use modules\transfer\models\CurrentEducation;
use modules\transfer\models\TransferMpgu;
use Mpdf\Tag\Tr;

class ConverterFaculty
{
    const OVER_FACULTY_PP = [14, 18];
    const OVER_FACULTY_H =  [9];
    const OVER_FACULTY_I =  [29];
    const IPP =  41;
    const IPH =  38;
    const IZH = 11;

    public static function searchFaculty ($faculty)
    {   if (in_array($faculty, self::OVER_FACULTY_PP)) {
            return self::IPP;
         }
         elseif (in_array($faculty, self::OVER_FACULTY_H)) {
            return self::IPH;
        }
        elseif (in_array($faculty, self::OVER_FACULTY_I)) {
            return self::IZH;
        }
        return $faculty;
    }
}