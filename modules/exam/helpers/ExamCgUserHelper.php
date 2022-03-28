<?php
namespace modules\exam\helpers;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\CompositeDiscipline;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\entrant\models\StatementCg;
use modules\entrant\models\UserDiscipline;
use modules\exam\models\Exam;

class ExamCgUserHelper
{
    private static function discipline($userId, $vi, $composite = false)
    {
        $viExam = UserDiscipline::find()->user($userId)->viFull()->select('discipline_select_id')
                ->groupBy('discipline_select_id')
                ->column();
        $ids =StatementCg::find()->statementUserCgIdActualColumn($userId, self::formCategory());
        if ($vi && !$viExam) {
            return false;
        }
        $query = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id OR discipline_competitive_group.spo_discipline_id=dict_discipline.id ')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->select(['dict_discipline.id'])
            ->andWhere(['dict_competitive_group.foreigner_status' => false])
            ->andWhere(['dict_competitive_group.id' => $ids, 'dict_discipline.is_och'=> 0]);
        if ($vi && $viExam) {
            if($composite) {
                $query->andWhere(['composite_discipline' => true]);
            }else{
                $query->andWhere(['dict_discipline.id' => $viExam]);
            }
        }
        else {
            $query->andWhere(['cse_subject_id' => null]);
        }
       return $query->distinct()->column();
    }

    public static function disciplineLevel($userId, $eduLevel, $formCategory, $faculty = null)
    {
        $viExam = $viExam = UserDiscipline::find()->user($userId)->viFull()->select('discipline_select_id')
            ->groupBy('discipline_select_id')
            ->column();
        $ids = StatementCg::find()->statementUserCgIdActualLevelColumn($userId, $eduLevel, $formCategory);
        $query = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->select(['dict_discipline.id'])
            ->andWhere(['dict_competitive_group.foreigner_status' => false])
            ->andWhere(['dict_competitive_group.id' => $ids, 'dict_discipline.is_och'=> 0]);
        if($faculty) {
           $query->andWhere(['dict_competitive_group.faculty_id' =>$faculty]);
        }
        if ($eduLevel==DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $viExam) {
            $query->andWhere(['dict_discipline.id'=> $viExam]);
            $query->orWhere(['and',['in','dict_discipline.id',
                CompositeDiscipline::find()
                    ->andWhere(['in', 'discipline_select_id', $viExam])
                    ->select('discipline_id')->groupBy('discipline_id')
                    ->column()], ['composite_discipline' => true], ['dict_competitive_group.id' => $ids]]);
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
        $data = self::discipline($userId, true);
        $viExam = UserDiscipline::find()->user($userId)->viFull()->select('discipline_select_id')
            ->groupBy('discipline_select_id')
            ->column();
        $composite =  self::discipline($userId, true, true);
        $composites = CompositeDiscipline::find()
            ->andWhere(['in', 'discipline_select_id', $viExam])
            ->andWhere(['in', 'discipline_id', $composite])
            ->select('discipline_select_id')->groupBy('discipline_select_id')
            ->column();
      $commonArray = $data ? array_merge($data, $composites) : [];
      return $commonArray;
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
        return time() > strtotime(date("Y").'-09-01');
    }


    private  static  function formCategory()
    {
//        return self::isTimeZa()
//            ? DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2 :
//            DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1 ;
        return [1,2];
    }
}