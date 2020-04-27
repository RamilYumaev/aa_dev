<?php

namespace modules\entrant\helpers;

use common\components\TbsWrapper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use olympic\helpers\auth\ProfileHelper;
use wapmorgan\yii2inflection\Inflector;
use Yii;
use yii\helpers\StringHelper;

class FileCgHelper
{
    public static function getFile($userId, $facultyId, $specialityId, $eduLevel, $specialRightId)
    {
        $tbs = new TbsWrapper();
        $tbs->openTemplate(self::templatePath($eduLevel, $specialRightId));
        $tbs->merge('profile', self::dataProfile($userId));
        $tbs->merge('education', self::dataEducation($userId));
        $tbs->merge('actual', self::addressActual($userId));
        $tbs->merge('registration', self::addressRegOrRes($userId));
        $tbs->merge('passport', self::passport($userId));
        $tbs->merge('faculty', self::facultyName($facultyId));
        $tbs->merge('language',self::languageList($userId));
        $tbs->merge('examinations',self::examinationsList($userId, $facultyId, $specialityId));
        $tbs->merge('cg', self::cgUser($userId, $facultyId, $specialityId));
        $tbs->download(self::fileName($eduLevel, $specialRightId));
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

    private static function fileName($eduLevel, $specialRightId)
    {
        return "Заявление ПK МПГУ " . date("Y") ." ".self::nameFile($eduLevel, $specialRightId). " " . date('Y-m-d H:i:s') . ".docx";
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

    public static function cgUser($userId, $facultyId, $specialityId)
    {
          $array = [];
          foreach ( DictCompetitiveGroupHelper::facultySpecialityAllUser(
                $userId,
                $facultyId,
                $specialityId) as $key => $cgUser)  /* @var $cgUser dictionary\models\DictCompetitiveGroup */
                {
                  $array[$key]['speciality']=  $cgUser->specialty->code." ".$cgUser->specialty->name;
                  $array[$key]['specialization']=  $cgUser->specialization->name ?? "";
                  $array[$key]['form']=  DictCompetitiveGroupHelper::formName($cgUser->education_form_id);
                  $array[$key]['special_right']= DictCompetitiveGroupHelper::specialRightName($cgUser->special_right_id);
                  $array[$key]['contract'] = self::finance($userId, $cgUser->faculty_id, $cgUser->speciality_id,
                    $cgUser->education_form_id,
                    $cgUser->specialization_id, DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT);
                    $array[$key]['budget'] = self::finance($userId, $cgUser->faculty_id, $cgUser->speciality_id,
                        $cgUser->education_form_id,
                        $cgUser->specialization_id, DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET);
        }
             return $array;
    }

    public static function languageList($user_id)
    {
        return [['data' => LanguageHelper::all($user_id)]];
    }

    public static function examinationsList($userId, $facultyId, $specialityId)
    {
        return [['data-spo' => DictCompetitiveGroupHelper::groupByExamsFacultyEduLevelSpecialization($userId, $facultyId, $specialityId),
                 'data-cse'=> DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($userId, $facultyId, $specialityId, true),
                 'data-no-cse'=> DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($userId, $facultyId, $specialityId,false)]];
    }


    public static function facultyName($facultyId)
    {
        return [['name'=>DictFacultyHelper::facultyName($facultyId)]];
    }

    public static function finance($userId, $facultyId, $specialityId, $eduForm, $specialisation, $typeFinance)
    {
        $finance = DictCompetitiveGroupHelper::financeUser($userId,
            $facultyId, $specialityId,
            $eduForm,
            $specialisation);

        return in_array($typeFinance, $finance) ? "X" : "";

    }



}