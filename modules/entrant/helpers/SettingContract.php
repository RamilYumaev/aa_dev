<?php


namespace modules\entrant\helpers;


use backend\widgets\olimpic\OlipicListInOLymipViewWidget;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictCompetitiveGroup;

class SettingContract
{
    private static $dateEndSpoMoscow = "2020-11-25 18:00:00";

    private static $dateEndBacMagMoscow = "2020-09-30 18:00:00";

    private static $dateEndGradMoscow = "2020-10-03 18:00:00";

    private static $dateEndFilial = "2020-10-30 17:00:00";

    public static function isJob(DictCompetitiveGroup $cg) {
        if ($cg->faculty_id == DictFacultyHelper::COLLAGE) {
            return strtotime(self::$dateEndSpoMoscow) > self::currentDate();
        }
        if (!$cg->isBudget()) {
            if ($cg->isHighGraduate()) {
                return strtotime(self::$dateEndGradMoscow) > self::currentDate();
            }
            if ($cg->isZaOchCg() && !$cg->isBachelorOrSpoFilial()) {
                return strtotime(self::$dateEndBacMagMoscow) > self::currentDate();
            }
            if ($cg->isZaOchCg() && $cg->isBachelorOrSpoFilial()) {
                return strtotime(self::$dateEndFilial) > self::currentDate();
            }
        }
        return false;
    }

    private static function currentDate()
    {
        return strtotime(\date("Y-m-d G:i:s"));
    }


}