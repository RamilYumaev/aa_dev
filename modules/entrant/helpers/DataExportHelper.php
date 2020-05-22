<?php


namespace modules\entrant\helpers;


use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Address;
use modules\entrant\models\Anketa;
use modules\entrant\models\Language;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
use olympic\models\auth\Profiles;

class DataExportHelper
{

    public  static function  dataIncoming($userId)
    {
        $profile = Profiles::findOne(['user_id'=> $userId]);
        $info = AdditionalInformation::findOne(['user_id'=> $profile->user_id]);
        $anketa = Anketa::findOne(['user_id'=> $profile->user_id]);
        $passport = PassportData::findOne(['user_id'=> $profile->user_id, 'main_status' => true]);
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
                'citizenship_id' =>$anketa->citizenship_id,
                'compatriot_status' => $anketa->isPatriot() ? 1 : 0,
                'hostel_need_status' => $info->hostel_id,
                'birthdate' => $passport->date_of_birth,
                'address_registration_country_id' => $addressRegistration ? $addressRegistration->country_id : "",
                'address_registration_postcode' =>  $addressRegistration ? $addressRegistration->postcode : "",
                'address_registration_region' =>  $addressRegistration ? $addressRegistration->region : "",
                'address_registration_district' => $addressRegistration ? $addressRegistration->district : "",
                'address_registration_city' =>  $addressRegistration ? $addressRegistration->city : "",
                'address_registration_village' =>  $addressRegistration ? $addressRegistration->village : "",
                'address_registration_street' =>  $addressRegistration ? $addressRegistration->street : "",
                'address_registration_house' =>  $addressRegistration ? $addressRegistration->house : "",
                'address_registration_housing' =>  $addressRegistration ? $addressRegistration->housing : "",
                'address_registration_building' =>  $addressRegistration ? $addressRegistration->building : "",
                'address_registration_flat' =>  $addressRegistration ? $addressRegistration->flat : "",
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
                'address_actual_country_id' =>$addressActual ? $addressActual->country_id : "",
                'address_actual_postcode' => $addressActual ? $addressActual->postcode : "",
                'address_actual_region' =>  $addressActual ? $addressActual->region : "",
                'address_actual_district' => $addressActual ? $addressActual->district : "",
                'address_actual_city' =>  $addressActual ? $addressActual->city : "",
                'address_actual_village' => $addressActual ? $addressActual->village : "",
                'address_actual_street' => $addressActual ? $addressActual->street : "",
                'address_actual_house' => $addressActual ? $addressActual->house : "",
                'address_actual_housing' => $addressActual ? $addressActual->housing : "",
                'address_actual_building' => $addressActual ? $addressActual->building : "",
                'address_actual_flat' =>  $addressActual ? $addressActual->flat : "",
                'phone_mobile' => $profile->phone,
                'phone_home' => "",
                'email' => $profile->user->email,
                'return_documents_way_id' =>0,
                'school_type_id' => $anketa->current_edu_level,
                'address_actual_to_registration_status' => "",
                'address_actual_to_residence_status' => "",
                'parallel_education_status' => 0,
                'advertising_source_id' => $info->resource_id,
                'incoming_type_id' => 3,
            ]
        ];
        return array_merge($result, self::dataLanguage($userId), self::dataDocumentPassport($userId));
    }

    public static function  dataCg($userId)
    {
        $result['applications'] = [];
        foreach (Statement::find()->user($userId)->statusNoDraft()->all() as $statement) {
            foreach ($statement->statementCg as $currentApplication) {
                $result['applications'][] = [
                    'competitive_group_id' => $currentApplication->cg->aais_id,
                   // 'cathedra_id' => $currentApplication->cathedra_id,
                ];
            }
        }
        return $result;
    }

    public static function  dataLanguage($userId)
    {
        $result['foreign_languages'] = [];
        foreach (Language::find()->where(['user_id'=>$userId])->all() as $currentLanguage) {
            $result['foreign_languages'][] = [
                'language_id' => $currentLanguage->language_id,
            ];
        }
        return $result;
    }

    public static function  dataDocumentPassport($userId)
    {
        $result['documents'] = [];
        foreach (PassportData::find()->where(['user_id'=>$userId])->all() as  $currentDocument) {
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
                'diploma_end_year' =>'',
                'surname' => '',
                'name' => '',
                'patronymic' => '',
                'amount' => 1,
                'main_status' => $currentDocument->main_status,
            ];
        }
        return $result;
    }



    private static  function  address($type, $user_id)
    {
       return Address::findOne(['user_id'=> $user_id, 'type'=> $type ]);
    }
}