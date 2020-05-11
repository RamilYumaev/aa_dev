<?php


namespace dictionary\helpers;


use common\helpers\EduYearHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DictSpeciality;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\helpers\CseViSelectHelper;
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

    const MAX_SPECIALTY_ALLOW = 3;

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

    public static function getEduLevelsGenitiveName(): array
    {
        return [self::EDUCATION_LEVEL_SPO => 'среднего профессионального образования',
            self::EDUCATION_LEVEL_BACHELOR => 'бакалавриата',
            self::EDUCATION_LEVEL_MAGISTER => 'магистратуры', self::EDUCATION_LEVEL_GRADUATE_SCHOOL => 'аспирантуры'];
    }


    public static function getEduLevelsAbbreviated(): array
    {
        return [self::EDUCATION_LEVEL_SPO => 'СПО', self::EDUCATION_LEVEL_BACHELOR => 'БАК',
            self::EDUCATION_LEVEL_MAGISTER => 'МАГ', self::EDUCATION_LEVEL_GRADUATE_SCHOOL => 'АСП'];
    }

    public static function getEduLevelsAbbreviatedShort(): array
    {
        return [self::EDUCATION_LEVEL_SPO => 'SPO', self::EDUCATION_LEVEL_BACHELOR => 'BAC',
            self::EDUCATION_LEVEL_MAGISTER => 'MAG', self::EDUCATION_LEVEL_GRADUATE_SCHOOL => 'GRA'];
    }


    public static function getEduLevelsAbbreviatedShortOne($key): string
    {
        return self::getEduLevelsAbbreviatedShort()[$key];
    }

    public static function getEduLevelsGenitiveNameOne($key): string
    {
        return self::getEduLevelsGenitiveName()[$key];
    }

    public static function getSpecialRightShort(): array
    {
        return [self::USUAL => 'USU', self::SPECIAL_RIGHT => 'SPE', self::TARGET_PLACE => 'TAR'];
    }

    public static function getSpecialRightShortOne($key): string
    {
        return self::getSpecialRightShort()[$key];
    }

    public static function getSpecialRight(): array
    {
        return [self::USUAL => 'Общий конкурс', self::SPECIAL_RIGHT => 'Особая квота',
            self::TARGET_PLACE => 'Прием на целевое обучение'];
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
        $speciality = DictSpecialityHelper::specialityCodeName($speciality_id);
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

    public static function getUrl($level, $specialRight, $govLineStatus)
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
        } else if ($govLineStatus) {
            switch ($level) {
                case DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR :
                    $url = "get-gov-line-bachelor";
                    break;
                case DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER :
                    $url = "get-gov-line-magistracy";
                    break;
                case DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL :
                    $url = "get-gov-line-graduate";
                    break;

                default :
                    $url = "#";

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

    public static function isAvailableCg(DictCompetitiveGroup $cg)
    {

        $anketa = \Yii::$app->user->identity->anketa();
        $permittedLevel = $anketa->getPermittedEducationLevels();
        if ($anketa->onlyCse()) {
            $userId = \Yii::$app->user->identity->getId();
            $userArray = DictDiscipline::cseToDisciplineConverter(
                CseSubjectHelper::userSubjects($userId));
            $finalUserArrayCse = DictDiscipline::finalUserSubjectArray($userArray);
            $filteredCg = \Yii::$app->user->identity->cseFilterCg($finalUserArrayCse);
            if (!in_array($cg->id, $filteredCg) && !in_array($cg->edu_level, $permittedLevel)) {
                throw new \DomainException("Конкурсная группа не доступна");
            }

        }
    }

    public static function educationLevelChecker($cg)
    {
        $anketa = \Yii::$app->user->identity->anketa();
        $permittedLevel = $anketa->getPermittedEducationLevels();

    }

    public static function budgetChecker(DictCompetitiveGroup $cg)
    {
        $anketa = \Yii::$app->user->identity->anketa();

        if ($anketa->onlyContract($cg->edu_level) && $cg->financing_type_id == self::FINANCING_TYPE_BUDGET) {
            throw new \DomainException("В рамках расматриваемого уровня образования Вы можете поступать только 
            на платные места");
        }
    }

    public static function groupByFacultyCountUser($user_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->select(['user_id', 'faculty_id'])
            ->groupBy(['user_id', 'faculty_id'])
            ->count();
    }

    public static function groupByFacultySpecialityAllUser($user_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->select(['user_id', 'faculty_id', 'edu_level', 'special_right_id', 'speciality_id'])
            ->groupBy(['user_id', 'faculty_id', 'edu_level', 'special_right_id', 'speciality_id'])
            ->all();
    }

    public static function groupByExams($user_id)
    {
        return DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id])
            ->andWhere(['not', ['cse_subject_id' => null]])
            ->select(['name', 'dict_discipline.id'])
            ->indexBy('dict_discipline.id')
            //  ->groupBy(['discipline_competitive_group.discipline_id'])
            ->column();
    }

    public static function groupByExamsFacultyEduLevelSpecialization($user_id, $faculty_id, $speciality_id, $ids)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.speciality_id' => $speciality_id, 'dict_competitive_group.id' => $ids])
            ->select(['name', 'dict_discipline.id'])
            ->indexBy('dict_discipline.id')
            //  ->groupBy(['discipline_competitive_group.discipline_id'])
            ->column();

        $ex = "";
        foreach ($data as $key => $value) {
            if ($key !== 99) {
                $ex .= $value . ", ";
            }
        }
        return $ex ? rtrim($ex, ", ") . "." : "";
    }


    public static function groupByExamsCseFacultyEduLevelSpecialization($user_id, $faculty_id, $speciality_id, $ids, $cse)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id])
            ->select(['name', 'dict_discipline.id', 'cse_subject_id'])
            ->asArray()
            ->all();

        return self::selectCseVi($data, $cse, $user_id) ?? self::stringExaminationsCse($data, $cse, $user_id);

    }

    private static function stringExaminationsCse($data, $cse, $user_id)
    {
        $ex = "";
        foreach ($data as $key => $value) {
            if ($cse) {
                if ($value['cse_subject_id']) {
                    $ex .= $value['name'] . " - " . CseSubjectHelper::maxMarkSubject($user_id)[$value['cse_subject_id']] . " балл(-а, ов), ";
                }
            } else {
                if (!$value['cse_subject_id']) {
                    $ex .= $value['name'] . ", ";
                }
            }
        }
        return $ex ? rtrim($ex, ", ") . "." : "";
    }

    private static function selectCseVi($data, $cse, $user_id)
    {
        if (CseViSelectHelper::modelOne($user_id)) {
            $ex = "";
            foreach ($data as $key => $value) {
                if (!$cse) {
                    if ($dataVi = CseViSelectHelper::modelOne($user_id)->dataVi()) {
                        if (in_array($value['id'], $dataVi)) {
                            $ex .= $value['name'] . ", ";
                        }
                    }
                    if (!$value['cse_subject_id']) {
                        $ex .= $value['name'] . ", ";
                    }
                } else {
                    if ($dataCse = CseViSelectHelper::modelOne($user_id)->dataCse()) {
                        if (array_key_exists($value['id'], $dataCse)) {
                            $ex .= $value['name'] . " - " . $dataCse[$value['id']][2] . " балл(-а, ов), ";
                        }

                    }
                }
            }
            return $ex ? rtrim($ex, ", ") . "." : "";
        }
        return null;
    }


    public static function cseSubjectId($id)
    {
        return DictDiscipline::findOne($id)->cse_subject_id;
    }

    public static function id($id)
    {
        return DictDiscipline::findOne(['cse_subject_id' => $id])->id;
    }

    public static function facultySpecialityExistsUser($user_id, $faculty_id, $speciality_id, $edu_level, $special_right)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->eduLevel($edu_level)
            ->specialRight($special_right)
            ->exists();
    }

    public static function bachelorExistsUser($user_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->eduLevel(self::EDUCATION_LEVEL_BACHELOR)
            ->exists();
    }

    public static function formOchExistsUser($user_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->eduLevel([self::EDUCATION_LEVEL_BACHELOR, self::EDUCATION_LEVEL_MAGISTER, self::EDUCATION_LEVEL_GRADUATE_SCHOOL])
            ->formEdu(self::EDU_FORM_OCH)
            ->exists();
    }


    public static function facultySpecialityAllUser($user_id, $faculty_id, $speciality_id, $ids = null)
    {
        $model = DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->select(['user_id', 'speciality_id', 'edu_level', 'special_right_id', 'education_form_id', 'faculty_id', 'specialization_id'])
            ->groupBy(['user_id', 'speciality_id', 'edu_level', 'special_right_id', 'education_form_id', 'faculty_id', 'specialization_id']);

        if ($ids) {
            return $model
                ->andWhere(['id' => $ids])
                ->all();
        }
        return $model->all();
    }


    public static function noMore3Specialty(DictCompetitiveGroup $cg)
    {
        $selectedCg = UserCg::find()
            ->select("cg_id")
            ->andWhere(["user_id" => \Yii::$app->user->getId()])
            ->column();
        $selectedSpecialty = DictCompetitiveGroup::find()->distinct()
            ->select("speciality_id")
            ->andWhere(["in", "id", $selectedCg])
            ->andWhere(['edu_level' => $cg->edu_level])
            ->column();
        if (count($selectedSpecialty) == self::MAX_SPECIALTY_ALLOW && !in_array($cg->speciality_id, $selectedSpecialty)) {
            throw new \DomainException("Заявления можно подавать только на три направления подготовки");
        }
        return true;
    }

    public static function financeUser($user_id, $faculty_id, $speciality_id, $education_form_id, $specialization_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->formEdu($education_form_id)
            ->specialization($specialization_id)
            ->select(['financing_type_id'])
            ->column();
    }


    public static function idAllUser($user_id, $faculty_id, $speciality_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->select(['id'])
            ->column();
    }

    public static function oneProgramGovLineChecker(DictCompetitiveGroup $cg)
    {
        $userCg = UserCg::findOne(["user_id" => \Yii::$app->user->identity->getId()]);


        if ($userCg && $cg->isGovLineCg()) {
            $cg1 = $userCg->competitiveGroup->fullNameCg;
            throw  new \DomainException("Можно выбрать только одну образовательную программу. 
            Вы уже выбрали \"$cg1\"");
        }
    }

    public static function getAllSumKcp($cg)
    {
        $targetKcp = DictCompetitiveGroup::targetKcp($cg) ? ", из них на целевое обучение -  "
            . DictCompetitiveGroup::targetKcp($cg) : "";

        $specialRightKcp = DictCompetitiveGroup::specialKcp($cg) ? ", из них особая квота - "
            . DictCompetitiveGroup::specialKcp($cg) : "";

        return DictCompetitiveGroup::kcpSum($cg) . $targetKcp . $specialRightKcp;

    }

}