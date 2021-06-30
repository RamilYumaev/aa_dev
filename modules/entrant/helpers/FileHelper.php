<?php


namespace modules\entrant\helpers;


use modules\entrant\models\Address;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\InsuranceCertificateUser;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\ReceiptContract;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\models\UserDiscipline;
use modules\entrant\readRepositories\FileReadCozRepository;
use modules\transfer\models\PacketDocumentUser;
use modules\transfer\models\PassExam;
use modules\transfer\models\StatementTransfer;
use Yii;

class FileHelper
{

    const STATUS_DRAFT = 0;
    const STATUS_WALT  = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;
    const STATUS_SEND = 4;

    public static function statusList() {
        return[
            self::STATUS_DRAFT =>"Готов к отправлению",
            self::STATUS_WALT=> "Обрабатывается",
            self::STATUS_ACCEPTED =>"Принято",
            self::STATUS_SEND =>"Отправлено",
            self::STATUS_NO_ACCEPTED =>"Не принято",];
    }

    public static function statusName($key) {
        return self::statusList()[$key];
    }

    public static function colorList() {
        return [
            self::STATUS_DRAFT =>"default",
            self::STATUS_WALT=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_SEND =>"info",
            ];
    }

    public static function colorName($key) {
        return self::colorList()[$key];
    }
    public static function listModels() {
        return [
            Statement::class,
            DocumentEducation::class,
            PassportData::class,
            InsuranceCertificateUser::class,
            Address::class,
            OtherDocument::class,
            Agreement::class,
            PersonalEntity::class,
            LegalEntity::class,
            StatementIndividualAchievements::class,
            StatementConsentPersonalData::class,
            \modules\transfer\models\StatementConsentPersonalData::class,
            StatementConsentCg::class,
            StatementRejectionCg::class,
            StatementRejection::class,
            StatementRejectionRecord::class,
            StatementRejectionCgConsent::class,
            StatementAgreementContractCg::class,
            StatementTransfer::class,
            PacketDocumentUser::class,
            ReceiptContract::class,
            UserDiscipline::class,
            PassExam::class,
        ];
    }

    public static function listModelsCOZ() {
        return [
            DocumentEducation::class,
            PassportData::class,
            Address::class,
            OtherDocument::class,
            StatementConsentPersonalData::class
        ];
    }

    public static function validateModel($hash){
        foreach(self::listModels() as  $model) {
          if(Yii::$app->getSecurity()->decryptByKey($hash, $model)) {
              return $model;
          }
        }
        return null;
    }

    public static function listCountModels() {
        return [
            DocumentEducation::class => 10,
            PassportData::class => 1,
            Address::class => 1,
            OtherDocument::class => 20,
            Agreement::class => 20,
            PersonalEntity::class=>5,
            LegalEntity::class=>5,
            InsuranceCertificateUser::class => 1,
            UserDiscipline::class =>1,
            StatementIndividualAchievements::class => 0,
            Statement::class => 0,
            \modules\transfer\models\StatementConsentPersonalData::class =>0,
            StatementConsentPersonalData::class => 0,
            StatementConsentCg::class => 0,
            StatementRejection::class => 0,
            StatementRejectionCgConsent::class =>0,
            StatementAgreementContractCg::class=>0,
            StatementRejectionRecord::class=>0,
            StatementRejectionCg::class =>0,
            StatementTransfer::class => 0,
            PacketDocumentUser::class => 20,
            ReceiptContract::class => 0,
            PassExam::class=>8,
        ];
    }

    public static function listHash() {
        return [
            DocumentEducation::class => 'doc',
            PassportData::class => "passport",
            Address::class => "address",
            OtherDocument::class => "other",
            Agreement::class => "agreement",
            PersonalEntity::class=>"personal",
            LegalEntity::class=>"legal",
            StatementIndividualAchievements::class => "id",
            Statement::class => "statement",
            \modules\transfer\models\StatementConsentPersonalData::class => 'personal_t',
            StatementConsentPersonalData::class => "personal",
            StatementConsentCg::class => "consent",
            StatementRejection::class =>'st-rejection',
            StatementRejectionRecord::class =>'st-rejection-record',
            StatementRejectionCgConsent::class => 'st-rejection-consent',
            StatementAgreementContractCg::class=> 'st-agreement',
            StatementRejectionCg::class =>'st-rejection-cg',
            ReceiptContract::class => "receipt-contract",
            InsuranceCertificateUser::class => 'snils',
            StatementTransfer::class => 'st-transfer',
            PacketDocumentUser::class => 'packet',
            UserDiscipline::class =>'ct',
            PassExam::class => 'exam-pass',
        ];
    }

    public static function listName() {
        return [
            DocumentEducation::class => "Документ об образовании",
            PassportData::class => "Паспортные даннные",
            Address::class => "Адрес",
            OtherDocument::class => "Прочие документы",
            Agreement::class => "Целевые договора",
            PersonalEntity::class=>"Данные заказчика (Ф)",
            LegalEntity::class=>"Данные заказчика (Ю)",
            StatementIndividualAchievements::class => "Индивидуальные достижения",
            Statement::class => "ЗУК",
            StatementConsentPersonalData::class => "Персональные данные",
            \modules\transfer\models\StatementConsentPersonalData::class => 'Персональные данные',
            StatementConsentCg::class => "ЗОС",
            StatementRejection::class =>'Отзыв ЗУК',
            StatementRejectionCgConsent::class => "Отзыв ЗОС",
            StatementAgreementContractCg::class=> 'Договор',
            StatementRejectionCg::class =>'Отзыв КГ',
            StatementRejectionRecord::class =>'Отзыв зачисления',
            ReceiptContract::class => "Квитанция",
            InsuranceCertificateUser::class => 'СНИЛС',
            UserDiscipline::class =>'Сертификаты ЦТ',
            StatementTransfer::class => 'Заявление перевода/восстановления',
            PacketDocumentUser::class => 'СКАНЫ',
            PassExam::class => 'Файлы',
        ];
    }

    public static function entrantJob() {
        return \Yii::$app->user->identity->jobEntrant();
    }

    public static function columnFioFile() {
        return (new FileReadCozRepository(self::entrantJob()))
            ->readData()->joinWith('profileUser')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)','files.user_id'])->indexBy('files.user_id')->column();
    }

}