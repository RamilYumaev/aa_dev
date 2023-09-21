<?php
namespace common\moderation\helpers;


use common\moderation\models\Moderation;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Address;
use modules\entrant\models\AisReturnData;
use modules\entrant\models\Anketa;
use modules\entrant\models\AverageScopeSpo;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\FIOLatin;
use modules\entrant\models\InsuranceCertificateUser;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\UserAis;
use modules\superservice\ais\Converter;
use olympic\models\auth\Profiles;
use wapmorgan\yii2inflection\Inflector;

class DataExportHelper
{
    public static function dataDocumentOne(Moderation $model, $id=null)
    {
        $aisModel = AisReturnData::findOne(['id' => $id]);
        $profile = Profiles::findOne(['user_id' => $model->created_by]);
        $incoming = UserAis::findOne(['user_id' => $model->created_by]);
        $userAnketa =  Anketa::findOne(['user_id' => $model->created_by]);
        $result = [];
        if($aisModel) {
            switch ($aisModel->model) {
                case PassportData::class :
                    $currentDocument = PassportData::findOne(['id' => $aisModel->record_id_sdo]);
                    $profile = Profiles::findOne(['user_id' => $currentDocument->user_id]);
                    $result['incomingPassport'] = [
                        'id' => $incoming->incoming_id,
                        'birthplace' => mb_strtoupper($currentDocument->place_of_birth, 'UTF-8'),
                        'birthdate' => $currentDocument->date_of_birth,
                    ];
                    $result['passportDocument'] = [
                            'sdo_id' => $currentDocument->id,
                            'id' => $aisModel->record_id_ais,
                            'model_type' => 1,
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
                            'main_status' => $currentDocument->main_status ?? 0,
                            'epgu_region_id' => '',
                        ] + Converter::generate($currentDocument->type_document,
                            $currentDocument->version_document,
                            $currentDocument->other_data);
                    return $result;
                    break;
                case DocumentEducation::class :
                    $currentDocument = DocumentEducation::findOne(['id' => $aisModel->record_id_sdo]);
                    $result['document'] = [
                            'sdo_id' => $currentDocument->id,
                            'id' => $aisModel->record_id_ais,
                            'model_type' => 3,
                            'document_type_id' => $currentDocument->type,
                            'document_series' => $currentDocument->series,
                            'document_number' => $currentDocument->number,
                            'document_issue' => $currentDocument->date,
                            'document_authority' => $currentDocument->schoolName,
                            'document_authority_code' => "",
                            'document_authority_country_id' => $currentDocument->school->country_id,
                            'diploma_authority' => $currentDocument->schoolName,
                            'diploma_specialty_id' => '',
                            'diploma_end_year' => $currentDocument->year,
                            'patronymic' => $currentDocument->patronymic ?? $profile->patronymic,
                            'surname' => $currentDocument->surname ?? $profile->last_name,
                            'name' => $currentDocument->name ?? $profile->first_name,
                            'amount' => 1,
                            'main_status' => 1,
                            'epgu_region_id' => $currentDocument->school->country_id == DictCountryHelper::RUSSIA ? $currentDocument->school->region->ss_id : "",
                        ] + Converter::generate($currentDocument->type_document,
                            $currentDocument->version_document,
                            $currentDocument->other_data, true);
                    return $result;
                    break;
                case OtherDocument::class :
                    $currentDocument = DocumentEducation::findOne(['user_id' => $model->created_by]);
                    $region = $currentDocument->school->country_id == DictCountryHelper::RUSSIA ? $currentDocument->school->region->ss_id : "";
                    $currentDocument = OtherDocument::findOne(['id' => $aisModel->record_id_sdo]);
                    $surname = "";
                    $name = "";
                    $patronymic = "";
                    if (in_array($currentDocument->type,
                        [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT,
                            DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT])) {
                        $documentCountryId = $userAnketa->citizenship_id;
                        $surname = $profile->last_name;
                        $name = $profile->first_name;
                        $patronymic = $profile->patronymic;
                    }
                    $result['document'] = [
                            'sdo_id' => $currentDocument->id,
                            'model_type' => 2,
                            'id' => $aisModel->record_id_ais,
                            'document_type_id' => $currentDocument->type,
                            'document_series' => $currentDocument->series,
                            'document_number' => $currentDocument->number,
                            'document_issue' => $currentDocument->date,
                            'document_authority' => mb_strtoupper($currentDocument->authority, 'UTF-8'),
                            'document_authority_code' => '',
                            'document_authority_country_id' => $currentDocument->country_id ?? $documentCountryId,
                            'diploma_authority' => '',
                            'diploma_specialty_id' => '',
                            'diploma_end_year' => '',
                            'surname' => $surname,
                            'name' => $name,
                            'patronymic' => $patronymic,
                            'amount' => $currentDocument->type == DictIncomingDocumentTypeHelper::ID_PHOTO ? $currentDocument->amount : 1,
                            'main_status' => 0,
                            'epgu_region_id' => $region,
                        ] + Converter::generate($currentDocument->type_document,
                            $currentDocument->version_document,
                            $currentDocument->other_data, true);
                    return $result;
                    break;
                }
            }else {
            switch ($model->model) {
                case Profiles::class:
                    $profile = $model->model::findOne($model->record_id);
                    $result['incomingProfile'] = [
                        'id' => $incoming->incoming_id,
                        'surname' => $profile->last_name,
                        'name' => $profile->first_name,
                        'patronymic' => $profile->patronymic,
                        'sex_id' => $profile->gender,
                        'surname_genitive' => \Yii::$app->inflection->inflectName($profile->last_name, Inflector::GENITIVE, $profile->gender),
                        'name_genitive' => \Yii::$app->inflection->inflectName($profile->first_name, Inflector::GENITIVE, $profile->gender),
                        'patronymic_genitive' => \Yii::$app->inflection->inflectName($profile->patronymic, Inflector::GENITIVE, $profile->gender),
                        'phone_mobile' => $profile->phone,
                    ];
                    return $result;
                    break;
                case Address::class:
                    /** @var Address $address */
                    $address = $model->model::findOne($model->record_id);
                    if($address->type == AddressHelper::TYPE_ACTUAL) {
                        $addressActual = $address;
                        $result['incomingAddressActual'] = [
                            'id' => $incoming->incoming_id,
                            'address_actual_country_id' => $addressActual ? $addressActual->country_id : $profile->country_id,
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
                            'address_actual_region_id' => $addressActual ? ($addressActual->dictRegion ? $addressActual->dictRegion->ss_id : "") : "",
                        ];
                    } elseif ($address->type == AddressHelper::TYPE_REGISTRATION) {
                        $addressRegistration = $address;
                        $result['incomingAddressRegistration'] = [
                            'id' => $incoming->incoming_id,
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
                            'address_registration_region_id' => $addressRegistration ? ($addressRegistration->dictRegion ? $addressRegistration->dictRegion->ss_id : "") : "",
                        ];
                    } else {
                        $addressResidence= $address;
                        $result['incomingAddressResidence'] = [
                            'id' => $incoming->incoming_id,
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
                        ];
                    }
                    return $result;
                    break;
                case AverageScopeSpo::class:
                    /** @var  AverageScopeSpo $average */
                    $average = $model->model::findOne($model->record_id);
                    $result['incomingAverageSpo'] = [
                        'id' => $incoming->incoming_id,
                        'overall_diploma_mark' => $average->average,
                        'overall_diploma_mark_common' => $average->average,
                    ];
                    return $result;
                    break;

                case AdditionalInformation::class:
                    /** @var AdditionalInformation $info */
                    $info = $model->model::findOne($model->record_id);
                    $result['incomingInfo'] = [
                        'id' => $incoming->incoming_id,
                        'hostel_need_status' => $info->hostel_id ? $info->hostel_id : 0,
                        'advertising_source_id' => $info->resource_id,
                        'mpgu_training_status' => $info->mpgu_training_status_id,
                        'chernobyl_status' => $info->chernobyl_status_id,
                        'special_conditions_status' => $info->voz_id,
                        'priority_school_status' => $info->is_military_edu,
                        'epgu_status' => $info->transfer_in_epgu,
                    ];
                    return $result;
                    break;
                case FIOLatin::class:
                    /** @var FIOLatin $fioLatin */
                    $fioLatin = $model->model::findOne($model->record_id);
                    $result['incomingFioLatin'] = [
                        'id' => $incoming->incoming_id,
                        'surname_lat' => $fioLatin ? $fioLatin->surname : "",
                        'name_lat' => $fioLatin ? $fioLatin->name : "",
                    ];
                    return $result;
                    break;
                case InsuranceCertificateUser::class:
                    /** @var InsuranceCertificateUser $snils */
                    $snils = $model->model::findOne($model->record_id);
                    $result['incomingSnils'] = [
                        'id' => $incoming->incoming_id,
                        'snils' => $snils->number,
                    ];
                    return $result;
                    break;
            }
        }
    }

    public static function dataEduction($id, $isSdoId = true)
    {
        $aisModel = AisReturnData::findOne($isSdoId ? ['record_id_sdo' => $id] : $id);
        $result = [];
        if($aisModel) {
            switch ($aisModel->model) {
                case DocumentEducation::class :
                    $currentDocument = DocumentEducation::findOne(['id' => $aisModel->record_id_sdo]);
                    $profile = Profiles::findOne(['user_id' => $currentDocument->user_id]);
                    $incoming = UserAis::findOne(['user_id' => $currentDocument->user_id]);
                    if($incoming) {
                    $result['document'] = [
                            'incoming_id' => $incoming->incoming_id,
                            'sdo_id' => $currentDocument->id,
                            'id' => $aisModel->record_id_ais,
                            'model_type' => 3,
                            'document_type_id' => $currentDocument->type,
                            'document_series' => $currentDocument->series,
                            'document_number' => $currentDocument->number,
                            'document_issue' => $currentDocument->date,
                            'document_authority' => $currentDocument->schoolName,
                            'document_authority_code' => "",
                            'document_authority_country_id' => $currentDocument->school->country_id,
                            'diploma_authority' => $currentDocument->schoolName,
                            'diploma_specialty_id' => '',
                            'diploma_end_year' => $currentDocument->year,
                            'patronymic' => $currentDocument->patronymic ?? $profile->patronymic,
                            'surname' => $currentDocument->surname ?? $profile->last_name,
                            'name' => $currentDocument->name ?? $profile->first_name,
                            'amount' => 1,
                            'main_status' => 1,
                            'epgu_region_id' => $currentDocument->school->country_id == DictCountryHelper::RUSSIA ? $currentDocument->school->region->ss_id : "",
                        ] + Converter::generate($currentDocument->type_document,
                            $currentDocument->version_document,
                            $currentDocument->other_data, true);
                    return $result;
                    }
                    return null;

                    break;
                case OtherDocument::class :
                    $currentDocument = OtherDocument::findOne(['id' => $aisModel->record_id_sdo]);
                    $profile = Profiles::findOne(['user_id' => $currentDocument->user_id]);
                    $currentDocumentEduction = DocumentEducation::findOne(['user_id' => $currentDocument->user_id]);
                    $userAnketa =  Anketa::findOne(['user_id' => $currentDocument->user_id]);
                    $region = $currentDocumentEduction->school->country_id == DictCountryHelper::RUSSIA ? $currentDocumentEduction->school->region->ss_id : "";
                    $surname = "";
                    $name = "";
                    $patronymic = "";
                    if (in_array($currentDocument->type,
                        [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT,
                            DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT])) {
                        $documentCountryId = $userAnketa->citizenship_id;
                        $surname = $profile->last_name;
                        $name = $profile->first_name;
                        $patronymic = $profile->patronymic;
                    }
                    $incoming = UserAis::findOne(['user_id' => $currentDocument->user_id]);
                    if($incoming) {
                        $result['document'] = [
                            'incoming_id' => $incoming->incoming_id,
                            'sdo_id' => $currentDocument->id,
                            'model_type' => 2,
                            'id' => $aisModel->record_id_ais,
                            'document_type_id' => $currentDocument->type,
                            'document_series' => $currentDocument->series,
                            'document_number' => $currentDocument->number,
                            'document_issue' => $currentDocument->date,
                            'document_authority' => mb_strtoupper($currentDocument->authority, 'UTF-8'),
                            'document_authority_code' => '',
                            'document_authority_country_id' => $currentDocument->country_id ?? $documentCountryId,
                            'diploma_authority' => '',
                            'diploma_specialty_id' => '',
                            'diploma_end_year' => '',
                            'surname' => $surname,
                            'name' => $name,
                            'patronymic' => $patronymic,
                            'amount' => $currentDocument->type == DictIncomingDocumentTypeHelper::ID_PHOTO ? $currentDocument->amount : 1,
                            'main_status' => 0,
                            'epgu_region_id' => $region,
                        ] + Converter::generate($currentDocument->type_document,
                            $currentDocument->version_document,
                            $currentDocument->other_data, true);
                    return $result;
                    }
                    return null;
                    break;
            }
        }
        return null;
    }
}
