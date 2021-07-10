<?php

namespace modules\entrant\helpers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\UserDiscipline;

class UserDisciplineHelper
{
    public static function
    allCtCse($userId): array
    {
        return UserDiscipline::find()->user($userId)->cseOrCt()
          ->select('discipline_select_id')
          ->groupBy('discipline_select_id')
          ->column();
    }

    public static function isCorrect($userId)
    {
        if(\Yii::$app->user->identity->anketa()->isTpgu())
        {
            return true;
        }

        if (\Yii::$app->user->identity->anketa()->onlyCse() && DictCompetitiveGroupHelper::bachelorExistsUser($userId)) {
            return count(self::allCtCse($userId)) >= CseSubjectHelper::MIN_NEEDED_SUBJECT_CSE;
        }

        $exams = DictCompetitiveGroupHelper::groupByExams($userId);
        $keys = array_values(array_flip($exams));
        $userDisciplinesCount = UserDiscipline::find()->user($userId)->discipline($keys)
            ->select('discipline_id')
            ->groupBy('discipline_id')->count();
        return count($keys) == $userDisciplinesCount;
    }
}