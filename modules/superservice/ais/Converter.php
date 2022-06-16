<?php
namespace modules\superservice\ais;

use modules\superservice\components\data\DocumentTypeVersionList;
use modules\superservice\forms\DocumentsDynamicForm;

class Converter
{
    private static function fieldsEpgu() {
       return[
        'DocNumber' => 'epgu_doc_number',
        'DocYear' => 'epgu_doc_year',
        'HasAppealed' => 'epgu_has_appealed',
        'IdAppealStatus' => 'epgu_appeal_status_id',
        'IdCompatriotCategory' => 'epgu_compatriot_category_id',
        'IdCompositionTheme' => 'epgu_composition_theme_id',
        'IdDisabilityType' => 'epgu_disability_type_id',
        'IdEducationLevel' => 'epgu_education_level_id',
        'IdOkcm' => 'epgu_okcm_id',
        'IdOlympic' => 'epgu_olympic_id',
        'IdOlympicDiplomaTypes' => 'epgu_olympic_diploma_type_id',
        'IdProfile' => 'epgu_olympic_profile_id',
        'IdRegion' => 'epgu_region_id',
        'IdSubject' => 'epgu_subject_id',
        'Mark' => 'epgu_mark',
        'NameDoc' => 'epgu_name_doc',
        'NameOrg' => 'epgu_name_org',
        'OlympiadNumber' => 'epgu_olympiad_number',
        'OlympiadYear' => 'epgu_olympiad_year',
        'RegisterNumber' => 'epgu_register_number',
        'Result' => 'epgu_result',
        'ResultDate' => 'epgu_result_date',
        'Type' => 'epgu_type',
        'Year' => 'epgu_year',
        'ExpirationDate' => 'epgu_expiration_date',
        'Indefinite' => 'epgu_indefinite',
        'IdOkso' => 'epgu_okso_id',
        ];
    }

    public static function generate($type, $version, $data, $showAllData = false)
    {
        $array = [];
        $array['epgu_document_type_id'] = $type;
        $array['epgu_document_version_id'] = self::getVersionDocument($version);
        $other_data = $data ? json_decode($data, true) : [];
        if ($showAllData) {
            foreach (array_flip(self::fieldsEpgu()) as $key => $value) {
                $array[$key] = $other_data && key_exists($value, $other_data) ? $other_data[$value] : null;
            };
            foreach (array_flip(self::categories()) as $key => $value) {
                $fields = self::getClsNames($version);
                if($fields
                    && key_exists('clsName', $fields)
                    && key_exists('IdCategory', $fields['clsName'])
                    && $other_data
                    && key_exists('IdCategory', $other_data)
                    && $fields['clsName']['IdCategory'] == $value
                ) {
                    $array[$key] = $other_data['IdCategory'];
                }else {
                    $array[$key] = null;
                }
            };
        }
        return $array;
    }

    private static function categories() {
        return [
            'ParentsLostCategoryList' => 'epgu_parents_lost_category_id',
            'MilitaryCategoryList' => 'epgu_military_category_id',
            'OrphanCategoryList' => 'epgu_orphan_category_id',
            'RadiationWorkCategoryList' => 'epgu_radiation_work_category_id',
            'VeteranCategoryList'=>'epgu_veteran_category_id'
        ];
    }

    public static function getVersionDocument($version) {
        $document = new DocumentTypeVersionList();
        $array = $document->getArray()->filter(function ($v) use ($version) {
            return $v['Id'] == $version;
        });
        if($data = array_values($array)) {
            return $data[0]['DocVersion'];
        }
    }

    public static function getClsNames($version) {
        return (new DocumentsDynamicForm($version))->getFields();
    }
}