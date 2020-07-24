<?php


namespace modules\exam\helpers;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\entrant\helpers\CseViSelectHelper;
use modules\entrant\models\StatementCg;
use modules\exam\models\Exam;

class ExamCgUserHelper
{
    private static function discipline($userId, $vi)
    {
        $viExam = CseViSelectHelper::viUser($userId);
        $ids =StatementCg::find()->statementUserCgIdActualColumn($userId, self::formCategory());
        if ($vi && !is_array($viExam)) {
            return false;
        }
        $query = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->select(['dict_discipline.id'])
            ->andWhere(['dict_competitive_group.id' => $ids, 'dict_discipline.is_och'=> 0]);
        if ($vi && is_array($viExam)) {
            $query->andWhere(['dict_discipline.id'=> $viExam ]);
        }
        else {
            $query->andWhere(['cse_subject_id' => null]);
        }
       return $query->distinct()->column();
    }

    public static function disciplineExam($userId) {
        $viAsCSE = self::examVIAsCse($userId);
        $vi =self::examVI($userId);
        if ($viAsCSE && $vi)  {
            $discipline = array_merge($viAsCSE, $vi);
        }elseif (!$viAsCSE && $vi)  {
            $discipline= $vi;
        }else {
            $discipline= $viAsCSE;
        }
       return $discipline;
    }

    private static function examVI($userId) {
       return self::discipline($userId, false);
    }

    private static function examVIAsCse($userId) {
       return self::discipline($userId, true);
    }

    public static function examExists($userId) {
        $discipline = self::disciplineExam($userId);
        if($discipline) {
            return Exam::find()->discipline($discipline)->exists();
        }
        return false;
    }

    public static function examList($userId) {
        $discipline = self::disciplineExam($userId);
        if($discipline) {
            return Exam::find()->discipline($discipline)->all();
        }
        return false;
    }

    public static function isTimeZa()
    {
        return time() < strtotime(date("Y").'-09-01');
    }


    private  static  function formCategory()
    {
        return self::isTimeZa()
            ? DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2 :
            DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1 ;
    }
}