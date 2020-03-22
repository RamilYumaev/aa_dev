<?php
namespace modules\entrant\widgets\cse;

use modules\entrant\models\CseSubjectResult;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CseSubjectMaxResultWidget extends Widget
{
    public function run()
    {
        return $this->render('max', [
            'maxSubjectResult' => $this->maxMarkSubject(),
        ]);
    }

    private function modelAll() {
        return $cseSubjectResult = CseSubjectResult::find()
            ->where(['user_id' => \Yii::$app->user->identity->getId()])->orderBy(['year'=> SORT_ASC])->all();
    }

    private function maxMarkSubject(){
        $array=[];
        if($this->modelAll()) {
            foreach ($this->modelAll() as $value) {
                foreach ($value->dateJsonDecode() as $item => $mark) {
                    if(!array_key_exists($item, $array)) {
                        $array[$item]=$mark;
                    } elseif ($array[$item] <= $mark){
                        $array[$item]=$mark;
                    }
                }
            }
        }
        return $array;
    }

}
