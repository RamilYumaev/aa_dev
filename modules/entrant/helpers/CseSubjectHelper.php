<?php


namespace modules\entrant\helpers;


use dictionary\models\DictDiscipline;
use modules\entrant\models\CseSubjectResult;

class CseSubjectHelper
{
    const MIN_NEEDED_SUBJECT_CSE = 2;

    private static function modelAll($userId)
    {
        return $cseSubjectResult = CseSubjectResult::find()
            ->where(['user_id' => $userId])->orderBy(['year' => SORT_ASC])->all();
    }

    public static function cseSubjectExists($userId)
    {
        return  CseSubjectResult::find()->where(['user_id' => $userId])->exists();
    }

    public static function maxMarkSubject($userId) :array
    {
        $array = [];
        if (self::modelAll($userId)) {
            foreach (self::modelAll($userId) as $value) {
                foreach ($value->dateJsonDecode() as $item => $mark) {
                    if (!array_key_exists($item, $array)) {
                        $array[$item] = $mark;
                    } elseif ($array[$item] <= $mark) {
                        $array[$item] = $mark;
                    }
                }
            }
        }
        return $array;
    }

    public static function listSubject($userId) :array
    {
        $list = [];
        if (self::modelAll($userId)) {
            foreach (self::modelAll($userId) as $value) {
                foreach ($value->dateJsonDecode() as $item => $mark) {
                        $list[$item] = $item;
                }
            }
        }
        return array_values($list);
    }

    public static function minNumberSubject($userId)
    {
        return count(self::maxMarkSubject($userId)) >= self::MIN_NEEDED_SUBJECT_CSE;
    }

    public static function userSubjects($userId)
    {
        return
            array_keys(self::maxMarkSubject($userId));
    }


}