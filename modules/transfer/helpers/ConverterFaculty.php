<?php


namespace modules\transfer\helpers;


use modules\transfer\models\CurrentEducation;
use modules\transfer\models\TransferMpgu;
use Mpdf\Tag\Tr;

class ConverterFaculty
{
    const OVER_FACULTY =  [14, 18];
    const IPP =  41;

    public static function searchFaculty ($faculty)
    {   if (in_array($faculty, self::OVER_FACULTY)) {
            return self::IPP;
         }
        return $faculty;
    }
}