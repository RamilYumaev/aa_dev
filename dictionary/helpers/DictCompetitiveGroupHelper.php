<?php


namespace dictionary\helpers;


use common\helpers\EduYearHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\models\UserCg;
use olympic\models\dictionary\Faculty;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class DictCompetitiveGroupHelper
{
    // уровни добранования
    const EDUCATION_LEVEL_SPO = 0;
    const EDUCATION_LEVEL_BACHELOR = 1;
    const EDUCATION_LEVEL_MAGISTER = 2;
    const EDUCATION_LEVEL_GRADUATE_SCHOOL = 3;

    // Формы обучения
    const EDU_FORM_OCH = 1;
    const EDU_FORM_OCH_ZAOCH = 2;
    const EDU_FORM_ZAOCH = 3;

    // виды финансирования
    const FINANCING_TYPE_BUDGET = 1;
    const FINANCING_TYPE_CONTRACT = 2;

    // тип конкурса
    const USUAL = null;
    const SPECIAL_RIGHT = 1;
    const TARGET_PLACE = 2;

    public static function getEduForms(): array
    {
        return [self::EDU_FORM_OCH => 'очная',
            self::EDU_FORM_OCH_ZAOCH => 'очно-заочная',
            self::EDU_FORM_ZAOCH => 'заочная'];
    }

    public static function getFinancingTypes(): array
    {
        return [self::FINANCING_TYPE_BUDGET => 'Бюджет', self::FINANCING_TYPE_CONTRACT => 'Договор'];
    }

    public static function getEduLevels(): array
    {
        return [self::EDUCATION_LEVEL_SPO => 'Среднее профессиональное образование', self::EDUCATION_LEVEL_BACHELOR => 'Бакалавриат',
            self::EDUCATION_LEVEL_MAGISTER => 'Магистратура', self::EDUCATION_LEVEL_GRADUATE_SCHOOL => 'Аспирантура'];
    }

    public static function getEduLevelsAbbreviated(): array
    {
        return [self::EDUCATION_LEVEL_SPO => 'СПО', self::EDUCATION_LEVEL_BACHELOR => 'БАК',
            self::EDUCATION_LEVEL_MAGISTER => 'МАГ', self::EDUCATION_LEVEL_GRADUATE_SCHOOL => 'АСП'];
    }

    public static function getSpecialRight(): array
    {
        return [self::USUAL => 'Обычная', self::SPECIAL_RIGHT => 'Квота', self::TARGET_PLACE => 'Целевое'];
    }

    public static function forms(): array
    {
        return [
            self::EDUCATION_LEVEL_SPO,
            self::EDUCATION_LEVEL_BACHELOR,
            self::EDUCATION_LEVEL_MAGISTER,
            self::EDUCATION_LEVEL_GRADUATE_SCHOOL
        ];
    }

    public static function allBranch()
    {
        return [];
    }

    public static function specialRight(): array
    {
        return [self::USUAL, self::SPECIAL_RIGHT, self::TARGET_PLACE];
    }

    public static function eduLevels(): array
    {
        return [self::EDUCATION_LEVEL_SPO, self::EDUCATION_LEVEL_BACHELOR,
            self::EDUCATION_LEVEL_MAGISTER, self::EDUCATION_LEVEL_GRADUATE_SCHOOL];
    }

    public static function financingTypes(): array
    {
        return [self::FINANCING_TYPE_BUDGET, self::FINANCING_TYPE_CONTRACT];

    }

    public static function formName($key): string
    {
        return ArrayHelper::getValue(self::getEduForms(), $key);
    }

    public static function financingTypeName($key): string
    {
        return ArrayHelper::getValue(self::getFinancingTypes(), $key);
    }

    public static function eduLevelName($key): string
    {
        return ArrayHelper::getValue(self::getEduLevels(), $key);
    }

    public static function eduLevelAbbreviatedName($key): string
    {
        return ArrayHelper::getValue(self::getEduLevelsAbbreviated(), $key);
    }

    public static function specialRightName($key): ?string
    {
        return ArrayHelper::getValue(self::getSpecialRight(), $key);
    }

    public static function dictCompetitiveGroupList($competitiveGroupsList): array
    {
        $array = [];
        foreach (DictCompetitiveGroup::find()->andWhere(
            ['id' => $competitiveGroupsList]
        )->asArray()->all() as $value) {
            $array[$value['id']] = self::getFullName($value['year'],
                $value['edu_level'],
                $value['speciality_id'],
                $value['specialization_id'],
                $value['faculty_id'],
                $value['education_form_id'],
                $value['financing_type_id']);
        };
        return $array;

    }

    public static function getFullName($year, $edu_level_id, $speciality_id, $specialization_id, $faculty_id, $education_form_id, $budget)
    {
        $edu_level = self::eduLevelAbbreviatedName($edu_level_id);
        $speciality = DictSpecialityHelper::specialityName($speciality_id);
        $specialization = DictSpecializationHelper::specializationName($specialization_id);
        $faculty = DictFacultyHelper::facultyName($faculty_id);
        $form_edu = self::formName($education_form_id);
        $budget = self::financingTypeName($budget);

        return $year
            . " / " . $edu_level
            . " / " . $faculty
            . " / " . $speciality
            . " / " . $specialization
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget;
    }

    public static function getUrl($level, $specialRight = null)
    {

        if ($specialRight) {
            switch ($specialRight) {
                case DictCompetitiveGroupHelper::SPECIAL_RIGHT :
                    $url = "get-special-right-bachelor";
                    break;
                case DictCompetitiveGroupHelper::TARGET_PLACE :
                    if ($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER) {
                        $url = "get-target-magistracy";
                    } elseif ($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
                        $url = "get-target-graduate";
                    } else {
                        $url = "get-target-bachelor";
                    }
                    break;
            }
        } else {
            switch ($level) {
                case DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO :
                    $url = "get-college";
                    break;
                case DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR :
                    $url = "get-bachelor";
                    break;
                case DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER :
                    $url = "get-magistracy";
                    break;
                case DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL :
                    $url = "get-graduate";
                    break;

                default :
                    $url = "#";

            }
        }

        return $url;
    }

    public static function saveChecked($id, $level)
    {
        $anketa = \Yii::$app->user->identity->anketa();
        $permittedLevel = $anketa->getPermittedEducationLevels();
        if ($anketa->onlyCse()) {
            $userId = \Yii::$app->user->identity->getId();
            $userArray = DictDiscipline::cseToDisciplineConverter(
                CseSubjectHelper::userSubjects($userId));
            $finalUserArrayCse = DictDiscipline::finalUserSubjectArray($userArray);
            $filteredCg = \Yii::$app->user->identity->cseFilterCg($finalUserArrayCse);
            if (!in_array($id, $filteredCg) && !in_array($level, $permittedLevel)) {
                throw new \DomainException("Конкурсная группа не доступна");
            }
        }
    }

    public static function groupByFacultyCountUser($user_id) {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->select(['user_id','faculty_id'])
            ->groupBy(['user_id','faculty_id'])
            ->count();
    }

    public static function groupByFacultySpecialityAllUser($user_id) {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->select(['user_id','faculty_id', 'edu_level', 'special_right_id', 'speciality_id'])
            ->groupBy(['user_id','faculty_id', 'edu_level', 'special_right_id',  'speciality_id'])
            ->all();
    }

    public static function groupByExams($user_id) {
        return DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(),'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(),'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere( ['user_cg.user_id'=> $user_id])
            ->andWhere(['not', ['cse_subject_id' => null]])
            ->orWhere(['composite_discipline' => true])
            ->select(['name','dict_discipline.id'])
            ->indexBy('dict_discipline.id')
          //  ->groupBy(['discipline_competitive_group.discipline_id'])
            ->column();
    }

    public static function cseSubjectId($id) {
        return DictDiscipline::findOne($id)->cse_subject_id;
    }

    public static function id($id) {
        return DictDiscipline::findOne(['cse_subject_id' => $id])->id;
    }

    public static function facultySpecialityAllUser($user_id, $faculty_id, $speciality_id ) {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->select(['user_id', 'speciality_id',  'edu_level', 'special_right_id', 'education_form_id', 'faculty_id', 'specialization_id'])
            ->groupBy(['user_id', 'speciality_id', 'edu_level', 'special_right_id', 'education_form_id', 'faculty_id', 'specialization_id'])
            ->all();
    }

    public static function financeUser($user_id, $faculty_id, $speciality_id, $education_form_id, $specialization_id ) {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->formEdu($education_form_id)
            ->specialization($specialization_id)
            ->select(['financing_type_id'])
            ->column();
    }

}