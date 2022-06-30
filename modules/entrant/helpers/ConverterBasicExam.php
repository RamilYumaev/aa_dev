<?php

namespace modules\entrant\helpers;

use common\auth\forms\SettingEmailEditForm;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;

class ConverterBasicExam
{
    private static function getCompositeDisciplines() {
        return [
            235 => [1,228],
            236 => [215,228],
            237 => [12,228],
            238 => [11, 228],
            239 => [3, 228],
            240 => [10, 228],
            241 => [8, 228],
            242 => [209, 228],
            243 => [222, 228],
            244 => [207, 228],
            245 => [214, 229],
            246 => [9, 229],
            247 => [203, 229],
            248 => [219, 229],
            249 => [9, 230],
            250 => [8, 231],
            251 => [9, 231],
            252 => [8, 232],
            253 => [3, 232],
            254 => [9, 232],
            255 => [8, 233],
            256 => [205, 234],
            257 => [5, 234]
        ];
    }

    public static function converter(DictCompetitiveGroup $group, $data) {
        $array = [];
        foreach ($data as $a => $item)  {
            $id = DictDiscipline::aisToSdoConverter($item);
            $dg = $group->getExaminations()->andWhere(['or',['discipline_id'=>$id], ['spo_discipline_id'=>$id]])->andWhere(['not', ['spo_discipline_id' => null]])->one();
            if($dg) {
                $discipline = $dg->discipline->ais_id;
                $disciplineSpo = $dg->disciplineSpo->ais_id;
                foreach (self::getCompositeDisciplines() as $key => $compositeDiscipline) {
                    if($compositeDiscipline[0] == $discipline && $compositeDiscipline[1] == $disciplineSpo) {
                        $array[$a] = $key;
                        break;
                    }
                }
            }else {
                $array[$a] = $item;
            }
        }
        return array_unique($array);
    }
}
