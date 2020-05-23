<?php


namespace modules\entrant\helpers;


use common\auth\forms\DeclinationFioForm;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Address;
use modules\entrant\models\Anketa;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\FIOLatin;
use modules\entrant\models\Language;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
use olympic\models\auth\Profiles;
use wapmorgan\yii2inflection\Inflector;

class DataExportHelper
{
    public static function dataIncoming($userId)
    {
        $profile = Profiles::findOne(['user_id' => $userId]);
        $info = AdditionalInformation::findOne(['user_id' => $profile->user_id]);
        $anketa = Anketa::findOne(['user_id' => $profile->user_id]);
        $fioLatin = FIOLatin::findOne(['user_id' => $profile->user_id]);
        $passport = PassportData::findOne(['user_id' => $profile->user_id, 'main_status' => true]);
        $other = OtherDocument::findOne(['user_id' => $profile->user_id, 'exemption_id' => true]);
        $addressActual = self::address(AddressHelper::TYPE_ACTUAL, $profile->user_id);
        $addressRegistration = self::address(AddressHelper::TYPE_REGISTRATION, $profile->user_id);
        $addressResidence = self::address(AddressHelper::TYPE_RESIDENCE, $profile->user_id);
        $result = [
            'incoming' => [
                'surname' => $profile->last_name,
                'name' => $profile->first_name,
                'patronymic' => $profile->patronymic,
                'sex_id' => $profile->gender,
                'birthplace' => mb_strtoupper($passport->place_of_birth, 'UTF-8'),
                'place_of_work' => "",
                'snils' => "",
                'inn' => "",
                'address_return_line' => "",
                'citizenship_id' => $anketa->citizenship_id,
                'compatriot_status' => $anketa->isPatriot() ? 1 : 0,
                'hostel_need_status' => $info->hostel_id ? $info->hostel_id : 0,
                'birthdate' => $passport->date_of_birth,
                'address_registration_country_id' => $addressRegistration ? $addressRegistration->country_id : "",
                'address_registration_postcode' => $addressRegistration ? $addressRegistration->postcode : "",
                'address_registration_region' => $addressRegistration ? $addressRegistration->region : "",
                'address_registration_district' => $addressRegistration ? $addressRegistration->district : "",
                'address_registration_city' => $addressRegistration ? $addressRegistration->city : "",
                'address_registration_village' => $addressRegistration ? $addressRegistration->village : "",
                'address_registration_street' => $addressRegistration ? $addressRegistration->street : "",
                'address_registration_house' => $addressRegistration ? $addressRegistration->house : "",
                'address_registration_housing' => $addressRegistration ? $addressRegistration->housing : "",
                'address_registration_building' => $addressRegistration ? $addressRegistration->building : "",
                'address_registration_flat' => $addressRegistration ? $addressRegistration->flat : "",
                'address_residence_postcode' => $addressResidence ? $addressResidence->postcode : "",
                'address_residence_region' => $addressResidence ? $addressResidence->region : "",
                'address_residence_district' => $addressResidence ? $addressResidence->district : "",
                'address_residence_city' => $addressResidence ? $addressResidence->city : "",
                'address_residence_village' => $addressResidence ? $addressResidence->village : "",
                'address_residence_street' => $addressResidence ? $addressResidence->street : "",
                'address_residence_house' => $addressResidence ? $addressResidence->house : "",
                'address_residence_housing' => $addressResidence ? $addressResidence->housing : "",
                'address_residence_building' => $addressResidence ? $addressResidence->building : "",
                'address_residence_flat' => $addressResidence ? $addressResidence->flat : "",
                'address_actual_country_id' => $addressActual ? $addressActual->country_id : "",
                'address_actual_postcode' => $addressActual ? $addressActual->postcode : "",
                'address_actual_region' => $addressActual ? $addressActual->region : "",
                'address_actual_district' => $addressActual ? $addressActual->district : "",
                'address_actual_city' => $addressActual ? $addressActual->city : "",
                'address_actual_village' => $addressActual ? $addressActual->village : "",
                'address_actual_street' => $addressActual ? $addressActual->street : "",
                'address_actual_house' => $addressActual ? $addressActual->house : "",
                'address_actual_housing' => $addressActual ? $addressActual->housing : "",
                'address_actual_building' => $addressActual ? $addressActual->building : "",
                'address_actual_flat' => $addressActual ? $addressActual->flat : "",
                'phone_mobile' => $profile->phone,
                'phone_home' => "",
                'email' => $profile->user->email,
                'return_documents_way_id' => 3,
                'school_type_id' => $anketa->current_edu_level,
                'address_actual_to_registration_status' => 0,
                'address_actual_to_residence_status' => 0,
                'parallel_education_status' => 0,
                'advertising_source_id' => $info->resource_id,
                'incoming_type_id' => 3,
                'photo_id' => "",
                'surname_genitive' => \Yii::$app->inflection->inflectName($profile->last_name, Inflector::GENITIVE, $profile->gender),
                'name_genitive' => \Yii::$app->inflection->inflectName($profile->first_name, Inflector::GENITIVE, $profile->gender),
                'patronymic_genitive' => \Yii::$app->inflection->inflectName($profile->patronymic, Inflector::GENITIVE, $profile->gender),
                'surname_lat' => $fioLatin ? $fioLatin->surname : "",
                'name_lat' => $fioLatin ? $fioLatin->surname : "",
                'reception_method_id' => 3,
                'mpgu_training_status' => 0,
                'military_status_id' => '',
                'military_doc_type_id' => '',
                'military_doc_series' => '',
                'military_doc_number' => '',
                'military_doc_issue' => '',
                'military_group_id' => '',
                'military_category_id' => '',
                'military_members' => '',
                'military_rank_id' => '',
                'military_specialty' => '',
                'military_fitness_id' => '',
                'military_recruitment_name' => '',
                'military_recruitment_address' => '',
                'military_reserve_type_id' => '',
                'quota_k1_status' => $other ? ($other->exemption_id == 1 ? 1 : 0) : 0,
                'quota_k2_status' => $other ? ($other->exemption_id == 2 ? 1 : 0) : 0,
                'quota_k3_status' => $other ? ($other->exemption_id == 3 ? 1 : 0) : 0,
                'special_conditions_status' => $info->voz_id,
                'creation_user_id' => '',
                'creation_date' => '',
                'update_user_id' => '',
                'update_date' => '',
                'valid_status' => 1,
                'checked_coz_status' => 1,
                'chernobyl_status' => '',
                'overall_diploma_mark' => '',
                'ol_version' => '',

            ]
        ];

        return array_merge($result, self::dataLanguage($userId), self::dataDocumentAll($userId, $profile));
    }

    public static function dataCSE($userId)
    {
        $result['cse'] = [];
        foreach (Statement::find()->user($userId)->statusNoDraft()->all() as $statement) {
            foreach ($statement->statementCg as $currentApplication) {
                $result['cse'][] = [
                    'competitive_group_id' => $currentApplication->cg->aais_id,
                    $result['incoming_id'] => '',
                    $result['date'] =>'',
                    $result['vi_status'] =>'',
                    $result['composite_discipline_id'] => '',
                    $result['preemptive_right_status'] => '',
                    $result['preemptive_right_level'] => '',
                    $result['statement_consent_status'] => '',
                    $result['statement_consent_date'] => '',
                    $result['benefit_BVI_status'] => '',
                    $result['target_organization_id'] => '',
                    $result['valid_status'] => ''
                ];
            }
        }
        return $result;
    }

    public static function dataCg($userId)
    {
        $result['applications'] = [];
        foreach (Statement::find()->user($userId)->statusNoDraft()->all() as $statement) {
            foreach ($statement->statementCg as $currentApplication) {
                $result['applications'][] = [
                    'competitive_group_id' => $currentApplication->cg->aais_id,
                    $result['incoming_id'] => '',
                    $result['date'] =>'',
                    $result['vi_status'] =>'',
                    $result['composite_discipline_id'] => '',
                    $result['preemptive_right_status'] => '',
                    $result['preemptive_right_level'] => '',
                    $result['statement_consent_status'] => '',
                    $result['statement_consent_date'] => '',
                    $result['benefit_BVI_status'] => '',
                    $result['target_organization_id'] => '',
                    $result['valid_status'] => ''
                ];
            }
        }
        return $result;
    }

    public static function dataLanguage($userId)
    {
        $result['foreign_languages'] = [];
        foreach (Language::find()->where(['user_id' => $userId])->all() as $currentLanguage) {
            $result['foreign_languages'][] = [
                'language_id' => $currentLanguage->language_id,
            ];
        }
        return $result;
    }

    public static function dataDocumentAll($userId, Profiles $profile)
    {
        $result['documents'] = [];

        foreach (PassportData::find()->where(['user_id' => $userId])->all() as $currentDocument) {
            $result['documents'][] = [
                'id' => $currentDocument->id,
                'document_type_id' => $currentDocument->type,
                'document_series' => $currentDocument->series,
                'document_number' => $currentDocument->number,
                'document_issue' => $currentDocument->date_of_issue,
                'document_authority' => mb_strtoupper($currentDocument->authority, 'UTF-8'),
                'document_authority_code' => $currentDocument->division_code,
                'document_authority_country_id' => $currentDocument->nationality,
                'diploma_authority' => '',
                'diploma_specialty_id' => '',
                'diploma_end_year' => '',
                'surname' => $profile->last_name,
                'name' => $profile->first_name,
                'patronymic' => $profile->patronymic,
                'amount' => 1,
                'main_status' => $currentDocument->main_status,
            ];
        }

        foreach (OtherDocument::find()->where(['user_id'=>$userId, 'type_note'=> null])->all() as  $currentDocument) {
            $result['documents'][] = [
                'id' => $currentDocument->id,
                'document_type_id' => $currentDocument->type,
                'document_series' => $currentDocument->series,
                'document_number' => $currentDocument->number,
                'document_issue' => $currentDocument->date,
                'document_authority' => mb_strtoupper($currentDocument->authority, 'UTF-8'),
                'document_authority_code' =>'',
                'document_authority_country_id' => "",
                'diploma_authority' => '',
                'diploma_specialty_id' => '',
                'diploma_end_year' =>'',
                'surname' => '',
                'name' => '',
                'patronymic' => '',
                'amount' => $currentDocument->type == DictIncomingDocumentTypeHelper::ID_PHOTO ? $currentDocument->amount :1,
                'main_status' => '',
            ];
        }

        foreach (DocumentEducation::find()->where(['user_id'=>$userId])->all() as  $currentDocument) {
            $result['documents'][] = [
                'id' => $currentDocument->id,
                'document_type_id' => $currentDocument->type,
                'document_series' => $currentDocument->series,
                'document_number' => $currentDocument->number,
                'document_issue' => $currentDocument->date,
                'document_authority' => "",
                'document_authority_code' => "",
                'document_authority_country_id' => $currentDocument->school->country_id,
                'diploma_authority' => $currentDocument->schoolName,
                'diploma_specialty_id' => '',
                'diploma_end_year' =>$currentDocument->year,
                'patronymic' => $currentDocument->patronymic ?? $profile->patronymic,
                'surname' => $currentDocument->surname ??  $profile->last_name,
                'name' => $currentDocument->name ?? $profile->first_name,
                'amount' => 1,
                'main_status' => 1,
            ];
        }
        return $result;
    }


    private static function address($type, $user_id)
    {
        return Address::findOne(['user_id' => $user_id, 'type' => $type]);
    }
}