<?php


namespace dictionary\helpers;


use common\helpers\EduYearHelper;
use dictionary\models\CompositeDiscipline;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\dictionary\helpers\DictCseSubjectHelper;
use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\helpers\CseViSelectHelper;
use modules\entrant\helpers\UserDisciplineHelper;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\UserCg;
use modules\entrant\models\UserDiscipline;
use Mpdf\Tag\U;
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
    const SPECIAL_QUOTA = 4;

    const MAX_SPECIALTY_ALLOW = 3;
    const FORM_EDU_CATEGORY_1 = 1;
    const FORM_EDU_CATEGORY_2 = 2;

    public static function getEduFormsForAgreement()
    {
        return [self::EDU_FORM_OCH => 'Очной',
            self::EDU_FORM_OCH_ZAOCH => 'Очно-заочной',
            self::EDU_FORM_ZAOCH => 'Заочной'];
    }

    public static function diplomaForEducationLevel()
    {
        return [
            self::EDUCATION_LEVEL_SPO => "диплом о среднем профессиональном образовании",
            self::EDUCATION_LEVEL_BACHELOR => "диплом бакалавра",
            self::EDUCATION_LEVEL_MAGISTER => "диплом магистра",
            self::EDUCATION_LEVEL_GRADUATE_SCHOOL => "диплом об окончании аспирантуры",
        ];
    }

    public static function eduLevelForAgreement()
    {
        return [
            self::EDUCATION_LEVEL_SPO => "среднее профессиональное образование",
            self::EDUCATION_LEVEL_BACHELOR => "бакалавриат",
            self::EDUCATION_LEVEL_MAGISTER => "магистратура",
            self::EDUCATION_LEVEL_GRADUATE_SCHOOL => "подготовка кадров высшей квалификации, 
            осуществляемая по результатам освоения программ подготовки научно-педагогических кадров в аспирантуре)",
        ];
    }

    public static function categoryForm()
    {
        return [
            self::FORM_EDU_CATEGORY_1 => [self::EDU_FORM_OCH, self::EDU_FORM_OCH_ZAOCH],
            self::FORM_EDU_CATEGORY_2 => self::EDU_FORM_ZAOCH,
        ];
    }

    public static function formCategory()
    {
        return [self::EDU_FORM_OCH => self::FORM_EDU_CATEGORY_1,
            self::EDU_FORM_OCH_ZAOCH => self::FORM_EDU_CATEGORY_1,
            self::EDU_FORM_ZAOCH => self::FORM_EDU_CATEGORY_2];
    }

    public static function getEduForms(): array
    {
        return [self::EDU_FORM_OCH => 'Очная',
            self::EDU_FORM_OCH_ZAOCH => 'Очно-заочная',
            self::EDU_FORM_ZAOCH => 'Заочная'];
    }

    public static function getEduFormsAccusative(): array
    {
        return [self::EDU_FORM_OCH => 'очную',
            self::EDU_FORM_OCH_ZAOCH => 'очно-заочную',
            self::EDU_FORM_ZAOCH => 'заочную'];
    }

    public static function eduLevelGenitive(): array
    {
        return [
            self::EDUCATION_LEVEL_SPO => "CПО",
            self::EDUCATION_LEVEL_BACHELOR => "бакалавриата",
            self::EDUCATION_LEVEL_MAGISTER => "магистратуры",
            self::EDUCATION_LEVEL_GRADUATE_SCHOOL => "аспирантуры",
        ];
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

    public static function getEduLevelsArrayIA(): array
    {
        return [self::EDUCATION_LEVEL_MAGISTER, self::EDUCATION_LEVEL_BACHELOR, self::EDUCATION_LEVEL_GRADUATE_SCHOOL];
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
        return [self::USUAL => 'USU', self::SPECIAL_RIGHT => 'SPEС', self::TARGET_PLACE => 'TAR', self::SPECIAL_QUOTA => "SPEC_Q"];
    }

    public static function getSpecialRightShortOne($key): string
    {
        return self::getSpecialRightShort()[$key];
    }

    public static function getSpecialRight(): array
    {
        return [self::USUAL => 'Общий конкурс', self::SPECIAL_RIGHT => 'Особая квота',
            self::TARGET_PLACE => 'Прием на целевое обучение', self::SPECIAL_QUOTA => 'Специальная квота'];
    }

    public static function getSpecialRightTesting(): array
    {
        return [0 => 'Общий конкурс', self::SPECIAL_RIGHT => 'Особая квота',
            self::TARGET_PLACE => 'Прием на целевое обучение', self::SPECIAL_QUOTA => 'Специальная квота'];
    }

    public static function forms(): array
    {
        return [
            self::EDU_FORM_OCH,
            self::EDU_FORM_OCH_ZAOCH,
            self::EDU_FORM_ZAOCH,
        ];
    }

    public static function allBranch()
    {
        return [];
    }

    public static function specialRight(): array
    {
        return [self::USUAL, self::SPECIAL_RIGHT, self::TARGET_PLACE, self::SPECIAL_QUOTA];
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

    public static function listFinances(): array
    {
        return [self::FINANCING_TYPE_BUDGET => 'Бюджет', self::FINANCING_TYPE_CONTRACT => "Договор"];

    }

    public static function formName($key): string
    {
        return ArrayHelper::getValue(self::getEduForms(), $key);
    }

    public static function formNameForAgreement($key): string
    {
        return ArrayHelper::getValue(self::getEduFormsForAgreement(), $key);
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
                $value['financing_type_id'],
                $value['special_right_id']);
        };
        return $array;

    }

    public static function dictCompetitiveGroupListG($competitiveGroupsList): array
    {
        $array = [];
        foreach (DictCompetitiveGroup::find()->andWhere(
            ['id' => $competitiveGroupsList]
        )->all() as $value) {
            $specialRight = $value->special_right_id ? self::specialRightName($value->special_right_id) : "";
            $array[$value->id] = $value->year
                . " / " . self::eduLevelAbbreviatedName($value->edu_level)
                . " / " . $value->faculty->full_name
                . " / " . $value->specialty->name
                . " / " . $value->specialization->name
                . " / " . self::formName($value->education_form_id)
                . " / " . self::financingTypeName($value->financing_type_id)
                . ($specialRight ? " / " . $specialRight : "");
        };
        return $array;

    }

    public static function getFullName($year, $edu_level_id, $speciality_id, $specialization_id, $faculty_id, $education_form_id, $budget, $special_right)
    {
        $edu_level = self::eduLevelAbbreviatedName($edu_level_id);
        $speciality = DictSpecialityHelper::specialityCodeName($speciality_id);
        $specialization = DictSpecializationHelper::specializationName($specialization_id);
        $faculty = DictFacultyHelper::facultyName($faculty_id);
        $form_edu = self::formName($education_form_id);
        $budget = self::financingTypeName($budget);
        $specialRight = $special_right ? self::specialRightName($special_right) : "";

        return $year
            . " / " . $edu_level
            . " / " . $faculty
            . " / " . $speciality
            . " / " . $specialization
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget
            . ($special_right ? " / " . $specialRight : "");
    }

    public static function getUrlString($level, $specialRight, $govLineStatus, $tpguStatus)
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
                case DictCompetitiveGroupHelper::SPECIAL_QUOTA:
                    $url = "get-special-quota-bachelor";
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
        } else if ($tpguStatus) {
            $url = "get-mpgu-tpgu";
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

    public static function getUrl(DictCompetitiveGroup $cg)
    {
        $specialRight = $cg->special_right_id;
        $level = $cg->edu_level;
        $govLineStatus = $cg->isGovLineCg();
        $tpguStatus = $cg->tpgu_status;
        return self::getUrlString($level, $specialRight, $govLineStatus, $tpguStatus);
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
                ->groupBy(['user_id', 'faculty_id', 'edu_level', 'special_right_id', 'speciality_id'])->all();
    }

    public static function groupByFacultySpecialityFormFinanceAllUser($user_id, $form, $finance)
    {
        $query = DictCompetitiveGroup::find()->userCg($user_id)
                 ->finance($finance)
                ->formEdu($form)->select(['user_id', 'faculty_id', 'edu_level', 'special_right_id', 'speciality_id','financing_type_id', 'foreigner_status'])
                ->groupBy(['user_id', 'faculty_id', 'edu_level', 'special_right_id', 'speciality_id', 'financing_type_id', 'foreigner_status']);
        return $query->all();
    }

    public static function groupByExams($user_id, $spo = false)
    {
       $query = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id])
            ->andWhere(['dict_competitive_group.foreigner_status' => false])
            ->andWhere(['not', ['cse_subject_id' => null]]);
            if($spo) {
                $query->andWhere(['spo_discipline_id' => null])
                    ->orWhere(['user_cg.user_id' => $user_id, 'composite_discipline' => true, 'spo_discipline_id' => null]);
            }else {
                $query->orWhere(['user_cg.user_id' => $user_id, 'composite_discipline' => true]);
            }
            $query->select(['name', 'dict_discipline.id'])
            ->indexBy('dict_discipline.id');
            return  $query->column();
    }

    public static function groupByExamsSpo($user_id)
    {
        return DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.spo_discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id])
            ->andWhere(['dict_competitive_group.foreigner_status' => false])
            ->select(['name', 'dict_discipline.id'])
            ->indexBy('dict_discipline.id')
            //  ->groupBy(['discipline_competitive_group.discipline_id'])
            ->column();
    }

    public static function groupByExamsSpoDiscipline($user_id, $spoDiscipline)
    {
        return DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id])
            ->andWhere(['spo_discipline_id' => $spoDiscipline])
            ->andWhere(['dict_competitive_group.foreigner_status' => false])
            ->select(['name', 'dict_discipline.id'])
            ->indexBy('dict_discipline.id')
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
            ->select(['name', 'dict_discipline.id', 'cse_subject_id', 'composite_discipline'])
            ->asArray()
            ->all();

        return self::selectCseVi($data, $cse, $user_id) ?? self::stringExaminationsCse($data, $cse, $user_id);
    }

    public static function groupByExamsCseFacultyEduLevelSpecializationF($user_id, $faculty_id, $speciality_id, $ids)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id])
            ->select(['name'])
            ->column();

        return $data ? implode(', ', $data) : '';
    }



    public static function groupByExamsCseFacultyEduLevelSpecializationN($user_id, $faculty_id, $speciality_id, $ids, $type)
    {
        $typeCse = 1;
        $typeCseVI = 2;
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id])
            ->select(['name', 'dict_discipline.id', 'cse_subject_id', 'composite_discipline'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($data as $value) {
            if($type == $typeCse) {
                if ($value['cse_subject_id'] && UserDiscipline::find()
                        ->cseOrCt()
                        ->user($user_id)
                        ->discipline($value['id'])
                        ->exists()) {
                    $result[] = $value['name'];
                }elseif($value['composite_discipline']) {
                    if(UserDiscipline::find()
                        ->cseOrCt()
                        ->user($user_id)
                        ->discipline($value['id'])
                        ->exists()) {
                            $result[] = UserDiscipline::find()
                                ->cseOrCt()
                                ->user($user_id)
                                ->discipline($value['id'])->one()->dictDisciplineSelect->name;
                    }else {
                        $name = self::getCompositeDiscipline($value['id'], $user_id);
                        if($name) {
                            $result[] = $name;
                        }
                    }
                }
            }
            elseif($type == $typeCseVI) {
                if ($value['cse_subject_id'] && UserDiscipline::find()
                        ->cseOrCtAndVi()
                        ->user($user_id)
                        ->discipline($value['id'])
                        ->exists()) {
                    $result[] = $value['name'];
                }elseif($value['composite_discipline']) {
                    if(UserDiscipline::find()
                        ->cseOrCtAndVi()
                        ->user($user_id)
                        ->discipline($value['id'])
                        ->exists()) {

                        $result[] = UserDiscipline::find()
                            ->cseOrCtAndVi()
                            ->user($user_id)
                            ->discipline($value['id'])->one()->dictDisciplineSelect->name;
                    }
                }
            }
            else {
                if((!$value['cse_subject_id'] && !$value['composite_discipline']) ||
                    ($value['cse_subject_id'] && UserDiscipline::find()
                    ->vi()
                    ->user($user_id)
                    ->discipline($value['id'])
                    ->exists())) {
                    $result[] = $value['name'];
                }elseif($value['composite_discipline']) {
                    if(UserDiscipline::find()
                        ->vi()
                        ->user($user_id)
                        ->discipline($value['id'])
                        ->exists()) {
                            $result[] = UserDiscipline::find()
                                ->vi()
                                ->user($user_id)
                                ->discipline($value['id'])->one()->dictDisciplineSelect->name;

                    }
                }
            }
        }
        return  $result ? implode(', ', $result) : "";
    }

    public static function groupByExamsCseFacultyEduLevelSpecializationSpo($user_id, $faculty_id, $speciality_id, $ids)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.spo_discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id])
            ->select(['name', 'dict_discipline.id', 'cse_subject_id', 'composite_discipline'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($data as $value) {
            if(UserDiscipline::find()->vi()->user($user_id)->discipline($value['id'])->exists()) {
                    $result[] = $value['name'];
            }
        }
        return  $result ? implode(', ', $result) : "";
    }

    public static function getCompositeDiscipline($disciplineId, $userId)
    {
        $models = CompositeDiscipline::find()->where(['discipline_id' => $disciplineId])
            ->select('discipline_select_id')->column();
        $userDiscipline = UserDiscipline::find()
                   ->cseOrCt()
                   ->user($userId)->disciplineSelect($models)->orderBy(['mark' => SORT_DESC])
                   ->one();
        return $userDiscipline &&  !UserDiscipline::find()->discipline($disciplineId)
            ->user($userId)->exists() ? $userDiscipline->dictDiscipline->name : "";
    }


    public static function groupByExamsNoCseId($user_id, $faculty_id, $speciality_id, $ids, $cse)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id])
            ->andWhere(['not', ['cse_subject_id' => null]])
            ->select(['dict_discipline.id'])
            ->column();

        return UserDiscipline::find()->user($user_id)->viFull()->discipline($data)->exists();

    }

    public static function groupByExamsNoCseCt($user_id, $faculty_id, $speciality_id, $ids)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id OR discipline_competitive_group.spo_discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id]);
            $data->select(['dict_discipline.id'])->column();

        return UserDiscipline::find()->discipline($data)->user($user_id)->viFull()->exists();
    }

    public static function groupByCompositeDiscipline($user_id, $faculty_id, $speciality_id, $ids)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id OR discipline_competitive_group.spo_discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id,
                'composite_discipline' =>true])
                 ->orWhere(['and',['not', ['discipline_competitive_group.spo_discipline_id' => null]],['composite_discipline' =>false,
                     'user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                     'dict_competitive_group.id' => $ids,
                     'dict_competitive_group.speciality_id' => $speciality_id,]])->all();
           $composites = [];
            foreach ($data as $item) {
                $userDiscipline = UserDiscipline::find()
                    ->andWhere(['not',[ 'type'=> UserDiscipline::NO]])
                    ->user($user_id)
                    ->orderBy(['mark' => SORT_DESC])
                    ->discipline($item->id)->one();
                if ($userDiscipline) {
                    $composites[] = $userDiscipline->dictDisciplineSelect->ais_id;
                } else {
                    foreach ($item->getComposite()->all() as $composite) {
                        $userDiscipline = UserDiscipline::find()
                            ->andWhere(['not',[ 'type'=> UserDiscipline::NO]])
                            ->user($user_id)
                            ->orderBy(['mark' => SORT_DESC])
                            ->disciplineSelect($composite->discipline_select_id)->one();
                        if ($userDiscipline) {
                            $composites[] = [$composite->dictDisciplineSelect->ais_id];
                        }
                    }
                }
            }
        return array_unique($composites);
    }

    public static function groupByDisciplineVi($user_id, $faculty_id, $speciality_id, $ids)
    {
       return DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id OR discipline_competitive_group.spo_discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserDiscipline::tableName(), 'discipline_user.discipline_id=dict_discipline.id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id,
                'discipline_user.user_id'=> $user_id,
                'discipline_user.type'=> [UserDiscipline::VI, UserDiscipline::CT_VI, UserDiscipline::CSE_VI],
                'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id])->select('dict_discipline.ais_id')
            ->column() ?? [];
    }

    public static function groupByExamsCseFacultyEduLevelSpecializationCompositeDiscipline($user_id, $faculty_id, $speciality_id, $ids)
    {
        $data = DictDiscipline::find()
            ->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=discipline_competitive_group.competitive_group_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.cg_id=dict_competitive_group.id')
            ->andWhere(['user_cg.user_id' => $user_id, 'dict_competitive_group.faculty_id' => $faculty_id,
                'dict_competitive_group.id' => $ids,
                'dict_competitive_group.speciality_id' => $speciality_id, 'composite_discipline' => true])
            ->select(['dict_discipline.id', 'dict_discipline.cse_subject_id'])
            ->asArray()
            ->all();

        return self::selectCseViCompositeDiscipline($data, true, $user_id) ??
            self::selectCseViCompositeDiscipline($data, false, $user_id) ??
            self::cseCompositeDiscipline($data, $user_id);

    }

    private static function stringExaminationsCse($data, $cse, $user_id)
    {
        $ex = "";
        foreach ($data as $key => $value) {
            if ($cse) {
                if ($value['cse_subject_id']) {
                    $ex .= $value['name'] . ", ";
                    /* $ex .= $value['name'] . " - " . CseSubjectHelper::maxMarkSubject($user_id)[$value['cse_subject_id']] . " балл(-а, ов), "; */
                }
                if ($value['id'] == DictCseSubjectHelper::LANGUAGE) {
                    $arrayComposite = [9 => 4, 10 => 5, 12 => 6, 11 => 7, 13 => 392];
                    $array = CseSubjectHelper::maxMarkSubject($user_id);
                    arsort($array);
                    foreach ($array as $key1 => $value1) {
                        if (key_exists($key1, $arrayComposite)) {
                            $ex .= $value['name'] . ", ";
                            /* $ex .= $value['name'] . " - " . CseSubjectHelper::maxMarkSubject($user_id)[$key1] . " балл(-а, ов), "; */
                            break;
                        }
                    }
                }
            } else {
                if (!$value['cse_subject_id'] && !$value['composite_discipline']) {
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
                        if (key_exists($value['id'], $dataVi)) {
                            if ($value['id'] == DictCseSubjectHelper::LANGUAGE) {
                                $ex .= DictCseSubjectHelper::listLanguage()[$dataVi[$value['id']]] . ", ";
                            } else {
                                $ex .= $value['name'] . ", ";
                            }

                        }
                    }
                    if (!$value['cse_subject_id'] && !$value['composite_discipline'] && $value['id'] != DictCseSubjectHelper::BALL_SPO_ID) {
                        $ex .= $value['name'] . ", ";
                    }
                } else {
                    if ($dataCse = CseViSelectHelper::modelOne($user_id)->dataCse()) {
                        if (array_key_exists($value['id'], $dataCse)) {
                            if ($value['id'] == DictCseSubjectHelper::LANGUAGE) {
                                $ex .= DictCseSubjectHelper::listLanguage()[$dataCse[$value['id']][1]] . " , ";
                                /*$ex .= DictCseSubjectHelper::listLanguage()[$dataCse[$value['id']][1]] . " - " . $dataCse[$value['id']][2] . " балл(-а, ов), ";*/
                            } else {
                                $ex .= $value['name'] . ", ";
                                /* $ex .= $value['name'] . " - " . $dataCse[$value['id']][2] . " балл(-а, ов), "; */
                            }
                        }

                    }
                }
            }
            return $ex ? rtrim($ex, ", ") . "." : "";
        }
        return null;
    }

    private static function selectCseViCompositeDiscipline($data, $cse, $user_id)
    {
        if (CseViSelectHelper::modelOne($user_id)) {
            $ex = null;
            foreach ($data as $key => $value) {
                if (!$cse) {
                    if ($dataVi = CseViSelectHelper::modelOne($user_id)->dataVi()) {
                        if (key_exists($value['id'], $dataVi)) {
                            if ($value['id'] == DictCseSubjectHelper::LANGUAGE) {
                                $ex = DictCseSubjectHelper::disciplineId($dataVi[$value['id']]);
                            }
                        }
                    }
                } else {
                    if ($dataCse = CseViSelectHelper::modelOne($user_id)->dataCse()) {
                        if (array_key_exists($value['id'], $dataCse)) {
                            if ($value['id'] == DictCseSubjectHelper::LANGUAGE) {
                                $ex = DictCseSubjectHelper::aisId($dataCse[$value['id']][1]);
                            }
                        }

                    }
                }
            }
            return $ex;
        }
        return null;
    }

    private static function cseCompositeDiscipline($data, $userId)
    {
        $arrayComposite = [9 => 4, 10 => 5, 12 => 6, 11 => 7, 13 => 392];
        $array = CseSubjectHelper::maxMarkSubject($userId);
        arsort($array);
        foreach ($data as $key => $value) {
            if ($value['id'] == DictCseSubjectHelper::LANGUAGE) {
                foreach ($array as $key1 => $value1)
                    if (key_exists($key1, $arrayComposite)) {
                        return DictCseSubjectHelper::aisId($key1);
                    }
            }
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

    public static function getFormsFromUserAndDiscipline($userId, $disciplineId): array
    {
        return DictCompetitiveGroup::find()->userCgAndExam($userId, $disciplineId)
            ->select('education_form_id')
            ->indexBy('education_form_id')
            ->column();
    }

    public static function getFormsFromUserAndDisciplineSpo($userId, $disciplineId): array
    {
        return DictCompetitiveGroup::find()->userCgAndExamSpo($userId, $disciplineId)
            ->select('education_form_id')
            ->indexBy('education_form_id')
            ->column();
    }

    public static function bachelorExistsUser($user_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->eduLevel(self::EDUCATION_LEVEL_BACHELOR)
            ->foreignerStatus(false)
            ->exists();
    }

    public static function formOchExistsUser($user_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)->notInFaculty()
            ->eduLevel([self::EDUCATION_LEVEL_BACHELOR, self::EDUCATION_LEVEL_MAGISTER, self::EDUCATION_LEVEL_GRADUATE_SCHOOL])
            ->formEdu(self::EDU_FORM_OCH)
            ->exists();
    }

    public static function eduSpoExistsUser($user_id)
    {
        return DictCompetitiveGroup::find()->userCg($user_id)
            ->eduLevel([self::EDUCATION_LEVEL_SPO])
            ->exists();
    }


    public static function facultySpecialityAllUser($user_id, $faculty_id, $speciality_id, $special_right, $ids = null)
    {
        $model = DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->specialRight($special_right)
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
        $rejectionCg = StatementRejection::find()
            ->select([StatementCg::tableName() . '.`cg_id`'])
            ->joinWith('statement.statementCg')
            ->andWhere(['user_id' => \Yii::$app->user->getId()])
            ->andWhere([StatementRejection::tableName().".`status_id`"=>2])
            ->column();
        $rejectionCg2 = StatementRejectionCg::find()
            ->select([StatementCg::tableName() . '.`cg_id`'])
            ->joinWith('statementCg.statement')
            ->andWhere(['user_id' => \Yii::$app->user->getId()])
            ->andWhere([StatementRejectionCg::tableName().".`status_id`" => 2])
            ->column();
        $arrayToUnset = array_merge($rejectionCg, $rejectionCg2);
       $totalArray = array_diff($selectedCg, $arrayToUnset);
        $selectedSpecialty = DictCompetitiveGroup::find()->distinct()
            ->select("speciality_id")
            ->andWhere(["in", "id", $totalArray])
            ->andWhere(['edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR])
            ->andWhere(['financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET])
            ->column();
        if (count($selectedSpecialty) == self::MAX_SPECIALTY_ALLOW && !in_array($cg->speciality_id, $selectedSpecialty) && $cg->isBudget()) {
            throw new \DomainException("Заявления на бюджет можно подавать только на три направления подготовки");
        }
        return true;
    }

    public static function financeUser($user_id, $faculty_id, $speciality_id, $education_form_id, $specialization_id, $specRight, $ids = null)
    {
        $query = DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->formEdu($education_form_id)
            ->specialRight($specRight)
            ->specialization($specialization_id);
        if ($ids) {
            $query->andWhere(['id' => $ids]);
        }
        $query->select(['financing_type_id']);
        return $query->column();
    }


    public static function idAllUser($user_id, $faculty_id, $speciality_id, $specRight, $form, $finance)
    {
        $query = DictCompetitiveGroup::find()->userCg($user_id)
            ->faculty($faculty_id)
            ->speciality($speciality_id)
            ->currentAutoYear()
            ->specialRight($specRight)
            ->formEdu($form);
            if($finance) {
                $query->finance($finance);
            }
            return $query
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
        $targetKcp = DictCompetitiveGroup::targetKcp($cg) ? ", из общего количества на целевое обучение -  "
            . DictCompetitiveGroup::targetKcp($cg) : "";

        $specialRightKcp = DictCompetitiveGroup::specialKcp($cg) ? ", из общего количества особая квота - "
            . DictCompetitiveGroup::specialKcp($cg) : "";

        return DictCompetitiveGroup::kcpSum($cg) . $targetKcp . $specialRightKcp;

    }

    public static function dataArray($cgId): array
    {
        $cg = DictCompetitiveGroup::findOne(['id' => $cgId]);

        return [
            'faculty' => $cg->faculty->full_name ?? "",
            'specialty' => $cg->specialty->getCodeWithName() ?? "",
            'specialization' => $cg->specialization->name ?? "",
            'education_level' => $cg->edu_level,
            'edu_form' => self::formName($cg->education_form_id) ?? "",
            'financing_type_id' => self::financingTypeName($cg->financing_type_id) ?? "",
            'is086' => $cg->enquiry_086_u_status,
            'foreigner_status' => $cg->foreigner_status,
            'special_right' => self::specialRightNameForAppZos()[$cg->special_right_id] ?? "На основные места",
        ];
    }

    public static function specialRightNameForAppZos()
    {
        return [
            self::SPECIAL_RIGHT => 'На места в пределах особой квоты',
            self::TARGET_PLACE => 'На места в пределах целевой квоты',
            self::SPECIAL_QUOTA => 'На места в пределах специальной квоты в соответствии с Указом Президента РФ №268 от 09.05.2022г.'
        ];
    }


    public static function tempAspIABlock($userId){
        $userCg = UserCg::find()->select('cg_id')->andWhere(['user_id'=>$userId])->column();
        return DictCompetitiveGroup::find()
            ->andWhere(['in','id',$userCg])
            ->andWhere(['edu_level'=>DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL])->exists();
    }


}