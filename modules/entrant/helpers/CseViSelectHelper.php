<?php


namespace modules\entrant\helpers;
use modules\entrant\models\CseViSelect;

class CseViSelectHelper
{
    public static function modelOne($userId): ?CseViSelect
    {
        return $cseSubjectResult = CseViSelect::findOne(['user_id' => $userId]);
    }

    public static function inKeyVi($key, array $data) {
        if($data) {
            if(in_array($key, $data)) {
                return 'Вступительное испытание';
            }
        }
        return null;
    }

    public static function inKeyCse($key, array $data, $n = null) {
        if($data) {
            if(array_key_exists($key, $data)) {
                return !is_null($n) ? $data[$key][$n] :'EГЭ';
            }
        }
        return null;
    }

}