<?php

namespace modules\entrant\helpers;

use common\components\TbsWrapper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use olympic\helpers\auth\ProfileHelper;
use Yii;

class FileCgHelper
{
    public static function getFile($userId, Statement $statement)
    {
        $tbs = new TbsWrapper();
        $tbs->openTemplate(self::templatePath($statement->edu_level, $statement->special_right));
        $tbs->merge('profile', self::dataProfile($userId));
        $tbs->merge('education', self::dataEducation($userId));
        $tbs->merge('actual', self::addressActual($userId));
        $tbs->merge('registration', self::addressRegOrRes($userId));
        $tbs->merge('passport', self::passport($userId));
        $tbs->merge('faculty', self::facultyName($statement->faculty_id));
        $tbs->merge('language',self::languageList($userId));
        $tbs->merge('examinations',self::examinationsList($userId, $statement->faculty_id, $statement->special_right, $statement->columnIdCg()));
        $tbs->merge('cg', self::cgUser($userId, $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg()));
        $tbs->download(self::nameFile($statement->edu_level, $statement->special_right));
    }

    private static function templatePath($eduLevel, $specialRightId)
    {
        return  Yii::getAlias("@common") . DIRECTORY_SEPARATOR . "file_templates" . DIRECTORY_SEPARATOR . self::nameTemplate($eduLevel, $specialRightId);
    }

    private static function nameTemplate($eduLevel, $specialRightId)
    {
        if($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO && !$specialRightId) {
            return "spo.docx";
        }
        elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER && !$specialRightId) {
            return "magister.docx";
        }
        elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && !$specialRightId) {
            return "bach_cas_cse.docx"; // bach_сas_cse_vi.docx

        }elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $specialRightId==DictCompetitiveGroupHelper::SPECIAL_RIGHT) {
            return "bach_ex.docx";
        }
        elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $specialRightId==DictCompetitiveGroupHelper::TARGET_PLACE) {
            return "bach_agreement.docx";
        }
        return "aspirantura.docx";
    }

    private static function nameFile($eduLevel, $specialRightId)
    {
        if($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO && !$specialRightId) {
            return "СПО";
        }
        elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER && !$specialRightId) {
            return "Магистратура";
        }
        elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && !$specialRightId) {
            return "(Бакалавриат) общий конкурс ЕГЭ"; // (Бакалавриат) общий конкурс ЕГЭ+ВИ

        }elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $specialRightId==DictCompetitiveGroupHelper::SPECIAL_RIGHT) {
            return "(Бакалавриат) льгота";
        }
        elseif($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $specialRightId==DictCompetitiveGroupHelper::TARGET_PLACE) {
            return "(Бакалавриат) целевой";
        }
        return "Аспирантура";
    }

    public static function fileName(Statement $statement, $extension = '.docx')
    {
        return "Заявление ПK МПГУ " . date("Y") ." ".self::nameFile($statement->edu_level, $statement->special_right). " " . date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameIA(StatementIndividualAchievements $statementIa, $extension = '.docx')
    {
        return "Заявление ПK МПГУ ИА" . date("Y") ." ".self::nameFile($statementIa->edu_level, null). " " . date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNamePD($extension = '.docx')
    {
        return "Заявление ПK МПГУ ПД" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameRejection($extension = '.docx')
    {
        return "Заявление ПK МПГУ ОТЗЫВ" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameConsent($extension = '.docx')
    {
        return "Заявление ПK МПГУ ЗОС" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameTpguAgreement($extension = '.docx')
    {
        return "Разрешение на заключение договора" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameWithoutAppendix($extension = '.docx')
    {
        return "Заявление о подачи без приложения (обложки)" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameStatementOther($extension = '.docx')
    {
        return "Согласие на заключение договора о целевом обучении" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameAgreement($extension = '.docx')
    {
        return "Договор об оказании платных образовательных услуг" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }

    public static function fileNameReceipt($extension = '.docx')
    {
        return "Квитанция" . date("Y") ." ". date('Y-m-d H:i:s') . $extension;
    }




    public static function dataProfile($userId)
    {
        return [ProfileHelper::dataArray($userId)];
    }

    public static function dataEducation($userId)
    {
        return [DocumentEducationHelper::dataArray($userId)];
    }

    public static function passport($userId)
    {
        return [PassportDataHelper::dataArray($userId)];
    }

    public static function addressActual($userId)
    {
        return [AddressHelper::actual($userId)];
    }

    public static function addressRegOrRes($userId)
    {
        return [AddressHelper::registrationResidence($userId)];
    }

    public static function cgUser($userId, $facultyId, $specialityId, $special_right,  $ids)
    {
          $array = [];
          foreach ( DictCompetitiveGroupHelper::facultySpecialityAllUser(
                $userId,
                $facultyId,
                $specialityId, $special_right, $ids) as $key => $cgUser)  /* @var $cgUser \dictionary\models\DictCompetitiveGroup */
                {
                  $array[$key]['speciality']=  $cgUser->specialty->code." ".$cgUser->specialty->name;
                  $array[$key]['specialization']=  $cgUser->specialization->name ?? "";
                  $array[$key]['form']=  DictCompetitiveGroupHelper::formName($cgUser->education_form_id);
                  $array[$key]['special_right']= DictCompetitiveGroupHelper::specialRightName($cgUser->special_right_id);
                  $array[$key]['contract'] = self::finance($userId, $cgUser->faculty_id, $cgUser->speciality_id,
                    $cgUser->education_form_id,
                    $cgUser->specialization_id, $cgUser->special_right_id,DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT, $ids);
                    $array[$key]['budget'] = self::finance($userId, $cgUser->faculty_id, $cgUser->speciality_id,
                        $cgUser->education_form_id,
                        $cgUser->specialization_id, $cgUser->special_right_id, DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET, $ids);
        }
             return $array;
    }

    public static function languageList($user_id)
    {
        return [['data' => LanguageHelper::all($user_id)]];
    }

    public static function examinationsList($userId, $facultyId, $specialityId, $ids)
    {
        return [['data-spo' => DictCompetitiveGroupHelper::groupByExamsFacultyEduLevelSpecialization($userId, $facultyId, $specialityId, $ids),
                 'data-cse'=> DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($userId, $facultyId, $specialityId, $ids, true),
                 'data-no-cse'=> DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($userId, $facultyId, $specialityId,  $ids, false)]];
    }


    public static function facultyName($facultyId)
    {
        return [['name'=>DictFacultyHelper::facultyName($facultyId)]];
    }

    public static function finance($userId, $facultyId, $specialityId, $eduForm, $specialisation, $specialRight,  $typeFinance, $ids)
    {
        $finance = DictCompetitiveGroupHelper::financeUser($userId,
            $facultyId, $specialityId,
            $eduForm,
            $specialisation, $specialRight, $ids);

        return in_array($typeFinance, $finance) ? "X" : "";

    }



}