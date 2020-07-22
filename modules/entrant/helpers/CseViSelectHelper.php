<?php


namespace modules\entrant\helpers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\CseViSelect;

class CseViSelectHelper
{
    public static function modelOne($userId): ?CseViSelect
    {
        return $cseSubjectResult = CseViSelect::findOne(['user_id' => $userId]);
    }

    public static function viUser ($userId)
    {
        $model = self::modelOne($userId);
        return $model && $model->dataVi() ? array_values($model->dataVi()): false;
    }

    public static function inKeyVi($key, array $data) {
        if($data) {
            if(key_exists($key, $data)) {
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

    public static function isCorrect($userId) {
        if((\Yii::$app->user->identity->anketa())->isTpgu())
        {
            return true;
        }
        $model =  self::modelOne($userId);
        $data = true;
        $exams = DictCompetitiveGroupHelper::groupByExams($userId);
        foreach($exams as $i => $item){
            $data = $model ? (self::inKeyVi($i, $model->dataVi()) ??  self::inKeyCse($i, $model->dataCse())) : false;
            if(!$data) {
                break;
            }
        }
        if (DictCompetitiveGroupHelper::bachelorExistsUser($userId) && !CseSubjectHelper::cseSubjectExists($userId)){
            return $data;
        }
       return true;
    }

    public static function dataInAIASCSE($userId)
    {
        $array = [];
        $model = self::modelOne($userId);
        if($model && $model->dataCse()) {
            foreach ($model->dataCse() as $item => $value) {
                if (array_key_exists($value[0], $array)) {
                    $array[$value[0]][] = [
                        'ex' => $item,
                        'language'=> $value[1],
                        'cse'=> $value[1],
                        'mark' => $value[2],
                    ] ;
                } else {
                    $array[$value[0]][0] = [
                        'ex' => $item,
                        'language'=> $value[1],
                        'cse'=> $value[1],
                        'mark' => $value[2]
                    ];
                }
            }
        }
        return $array;
    }



}