<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Address;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\File;
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
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\readRepositories\ReceiptReadRepository;
use modules\entrant\repositories\AddressRepository;
use modules\entrant\repositories\AgreementRepository;
use modules\entrant\repositories\DocumentEducationRepository;
use modules\entrant\repositories\FileRepository;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\PassportDataRepository;
use modules\entrant\repositories\ReceiptContractRepository;
use modules\entrant\repositories\StatementAgreementContractCgRepository;
use modules\entrant\repositories\StatementConsentCgRepository;
use modules\entrant\repositories\StatementIndividualAchievementsRepository;
use modules\entrant\repositories\StatementPersonalDataRepository;
use modules\entrant\repositories\StatementRejectionCgConsentRepository;
use modules\entrant\repositories\StatementRejectionCgRepository;
use modules\entrant\repositories\StatementRejectionRecordRepository;
use modules\entrant\repositories\StatementRejectionRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\SubmittedDocumentsRepository;
use modules\transfer\models\PacketDocumentUser;
use modules\transfer\models\StatementTransfer;
use Prophecy\Doubler\ClassPatch\SplFileInfoPatch;

class SubmittedDocumentsService
{
    private $repository;
    private $manager;
    private $statementRepository;
    private $achievementsRepository;
    private $personalDataRepository;
    private $statementConsentCgRepository;
    private $fileRepository;
    private $statementRejectionRepository;
    private $statementRejectionCgRepository;
    private $rejectionCgConsentRepository;
    private $statementAgreementContractCgRepository;
    private $receiptContractRepository;
    private $rejectionRecordRepository;


    public function __construct(SubmittedDocumentsRepository $repository,
                                StatementRepository $statementRepository,
                                StatementIndividualAchievementsRepository $achievementsRepository,
                                StatementPersonalDataRepository $personalDataRepository,
                                StatementConsentCgRepository $statementConsentCgRepository,
                                StatementRejectionRepository $statementRejectionRepository,
                                StatementRejectionCgRepository $statementRejectionCgRepository,
                                StatementRejectionCgConsentRepository $rejectionCgConsentRepository,
                                StatementAgreementContractCgRepository $statementAgreementContractCgRepository,
                                StatementRejectionRecordRepository $rejectionRecordRepository,
                                FileRepository $fileRepository,
                                ReceiptContractRepository $receiptContractRepository,
                                TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->statementRepository = $statementRepository;
        $this->achievementsRepository = $achievementsRepository;
        $this->statementConsentCgRepository = $statementConsentCgRepository;
        $this->personalDataRepository = $personalDataRepository;
        $this->statementRejectionRepository = $statementRejectionRepository;
        $this->statementRejectionCgRepository = $statementRejectionCgRepository;
        $this->rejectionCgConsentRepository = $rejectionCgConsentRepository;
        $this->receiptContractRepository = $receiptContractRepository;
        $this->statementAgreementContractCgRepository = $statementAgreementContractCgRepository;
        $this->fileRepository = $fileRepository;
        $this->rejectionRecordRepository = $rejectionRecordRepository;
    }

    public function create($type, $user_id)
    {
        $this->manager->wrap(function () use ($type, $user_id) {
            $this->saveModel($type, $user_id);
        });
    }

    public function send($user_id)
    {
        $this->manager->wrap(function () use ($user_id) {
            $this->passport($user_id);
            $this->address($user_id);
            $this->ldnr($user_id);
            $this->documentEdu($user_id);
            $this->agreement($user_id);
            $this->other($user_id);
            $this->statement($user_id);
            $this->statementConsent($user_id);
            $this->statementIndividualAchievements($user_id);
            $this->statementPd($user_id);
            $this->statementRejection($user_id);
            $this->statementRejectionCg($user_id);
            $this->statementConsentRejection($user_id);
            $this->statementAgreement($user_id);
            $this->receiptAgreement($user_id);
            $this->files($user_id);
        });
    }

    public function transferSend($user_id)
    {
        $this->manager->wrap(function () use ($user_id) {
            $this->passport($user_id);
            $this->statementTransfer($user_id);
            $this->packetDocument($user_id);
            $this->files($user_id);
        });
    }


    public function sendRecord($user_id)
    {
        $this->manager->wrap(function () use ($user_id) {
            $this->statementRejectionRecord($user_id);
            $this->files($user_id);
        });
    }


    private function files($userId)
    {
        $files = File::find()->user($userId)->status(FileHelper::STATUS_DRAFT)->all();
        /* @var $statement \modules\entrant\models\File */
        foreach ($files as $file) {
            $file->setStatus(FileHelper::STATUS_WALT);
            $this->fileRepository->save($file);
        }
    }

    private function statement($userId)
    {
        $statements = Statement::find()->user($userId)->status(StatementHelper::STATUS_DRAFT)->all();
        /* @var $statement \modules\entrant\models\Statement */
        $anketa = Anketa::findOne(['user_id' =>$userId]);

        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы заявления №' . $statement->numberStatement . '!');
            }
            if($anketa->isWithOitCompetition() || $anketa->isExemption() || ($anketa->isAgreement() && $statement->isSpecialRightStatement())) {
                $statement->setStatus(StatementHelper::STATUS_WALT_SPECIAL);
            }else {
                $statement->setStatus(StatementHelper::STATUS_WALT);
            }

            $this->statementRepository->save($statement);
        }
    }

    private function statementRejectionRecord($userId)
    {
        $statements = StatementRejectionRecord::find()->andWhere(['user_id' => $userId, 'status' => StatementHelper::STATUS_DRAFT])->all();
        /* @var $statement \modules\entrant\models\StatementRejectionRecord */

        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы заявления!');
            }
            $statement->setStatus(StatementHelper::STATUS_WALT);

            $this->rejectionRecordRepository->save($statement);
        }
    }

    private function statementConsent($userId)
    {
        $statements = StatementConsentCg::find()->statementStatus($userId, StatementHelper::STATUS_DRAFT)->all();
        /* @var $statement \modules\entrant\models\StatementConsentCg */
        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы заявления о согласии на зачисление!');
            }
            $statement->setStatus(StatementHelper::STATUS_WALT);
            $this->statementConsentCgRepository->save($statement);
        }
    }

    private function statementRejection($userId)
    {
        $statements = StatementRejection::find()->statementStatus($userId, StatementHelper::STATUS_DRAFT)->all();
        /* @var $statement \modules\entrant\models\StatementRejection */
        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы заявления отзыва!');
            }
            $statement->setStatus(StatementHelper::STATUS_WALT);
            $this->statementRejectionRepository->save($statement);
        }
    }


    private function statementConsentRejection($userId)
    {
        $statements = StatementRejectionCgConsent::find()->statementStatus($userId, StatementHelper::STATUS_DRAFT)->all();
        /* @var $statement \modules\entrant\models\StatementRejectionCgConsent */
        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы заявления отзыва о согласии на зачисление!');
            }
            $statement->setStatus(StatementHelper::STATUS_WALT);
            $this->rejectionCgConsentRepository->save($statement);
        }
    }

    private function statementRejectionCg($userId)
    {
        $statements = StatementRejectionCg::find()->statementStatus($userId, StatementHelper::STATUS_DRAFT)->all();
        /* @var $statement \modules\entrant\models\StatementRejectionCg */
        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы заявления об отзыве!');
            }
            $statement->setStatus(StatementHelper::STATUS_WALT);
            $this->statementRejectionCgRepository->save($statement);
        }
    }

    private function statementAgreement($userId)
    {
        $statements = StatementAgreementContractCg::find()->statementStatus($userId, null)->all();
        /* @var $statement \modules\entrant\models\StatementAgreementContractCg */
        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы договора!');
            }
            if($statement->typeLegal()) {
                $this->legal($statement->record_id, $userId);
            }else if($statement->typePersonal()) {
                $this->personal($statement->record_id, $userId);
            }
            $statement->setStatus(StatementHelper::STATUS_WALT);
            $this->statementAgreementContractCgRepository->save($statement);
        }
    }

    private function receiptAgreement($userId)
    {
        $receipts = ReceiptContract::find()->receiptStatus($userId, 0)->all();
        /* @var $receipt \modules\entrant\models\ReceiptContract */
        foreach ($receipts as $receipt) {
            if (!$receipt->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы квитанции!');
            }
            $receipt->setStatus(StatementHelper::STATUS_WALT);
            $this->receiptContractRepository->save($receipt);
        }
    }



    private function statementIndividualAchievements($userId)
    {
        $statements = StatementIndividualAchievements::find()->status(StatementHelper::STATUS_DRAFT)->user($userId)->all();
        /* @var $statement \modules\entrant\models\StatementIndividualAchievements */
        foreach ($statements as $statement) {
            if (!$statement->countFilesAndCountPagesTrue()) {
                throw new \DomainException('Загружены не все файлы заявления об учете индивидуального достижения!');
            }
            $statement->setStatus(StatementHelper::STATUS_WALT);
            $this->achievementsRepository->save($statement);
        }
    }

    private function other($userId)
    {
        $others = OtherDocument::find()->where(['user_id' => $userId])->all();
        /* @var $other \modules\entrant\models\OtherDocument */
        foreach ($others as $other) {
            if (!$other->files) {
                throw new \DomainException(' Не загружен файл(-ы) раздела "Прочие документы" к типу ' . $other->typeName . '!');
            }
        }
    }

    private function passport($userId)
    {
        $other = PassportData::find()->where(['user_id' => $userId, 'main_status' => true])->one();
        if (!$other->files) {
            throw new \DomainException(' Не загружен файл(-ы) раздела "Паспортные данные" к типу ' . $other->typeName . '!');
        }
    }

    private function legal($id, $userId)
    {
        $legal = LegalEntity::findOne(['id' => $id, 'user_id' => $userId]);
        if ($legal && !$legal->files) {
            throw new \DomainException(' Не загружен скан(-ы) юридического лица!');
        }
    }

    private function personal($id, $userId)
    {
        $personal = PersonalEntity::findOne(['id' => $id, 'user_id' => $userId]);
        if ($personal && !$personal->files) {
            throw new \DomainException(' Не загружен скан(-ы) законного представителя!');
        }
    }


    private function documentEdu($userId)
    {
        $other = DocumentEducation::find()->where(['user_id' => $userId])->one();
        if (!$other->files) {
            throw new \DomainException(' Не загружен файл(-ы) раздела "Документ об образовании" к типу ' . $other->typeName . '!');
        }
    }

    private function agreement($userId)
    {
        $other = Agreement::find()->where(['user_id' => $userId])->one();
        if ($other && !$other->files) {
            throw new \DomainException(' Не загружен файл(-ы) раздела "Документ о целевом обучении" к типу !');
        }
    }


    private function ldnr($userId)
    {
        $other = Anketa::findOne(['user_id' => $userId, 'is_dlnr_ua' => true]);
        if ($other && !$other->filesUser) {
            throw new \DomainException(' Не загружен файл(-ы) раздела "Гражданин РФ, который до прибытия на территорию Российской Федерации проживал на территории ДНР, ЛНР"!');
        }
    }

    private function address($userId)
    {
        $others = Address::find()->where(['user_id' => $userId, 'type' => [AddressHelper::TYPE_REGISTRATION, AddressHelper::TYPE_RESIDENCE]])->all();
        /* @var $other \modules\entrant\models\Address */
        foreach ($others as $other) {
            if (!$other->files) {
                throw new \DomainException(' Не загружен файл(-ы) раздела "Адреса" к типу ' . $other->typeName . '!');
            }
        }
    }


    private function statementPd($userId)
    {
        $statement = $this->personalDataRepository->get($userId);
        if (!$statement->countFilesAndCountPagesTrue()) {
            throw new \DomainException('K заялениию "Персональные данные" загружены  не все файлы !');
        }
    }


    public function saveModel($type, $user_id)
    {
        if (($model = $this->repository->getUser($user_id)) !== null) {
            $model->data($type, $user_id);
        } else {
            $model = SubmittedDocuments::create($type, $user_id);
        }
        $this->repository->save($model);
    }

    private function packetDocument($userId)
    {
        $others = PacketDocumentUser::find()->where(['user_id' => $userId])->all();
        /* @var $other \modules\transfer\models\PacketDocumentUser */
        foreach ($others as $other) {
            if (!$other->files) {
                throw new \DomainException(' Не загружен файл(-ы) ' . $other->typeName . '!');
            }
        }
    }

    private function statementTransfer($userId)
    {
        $statement = StatementTransfer::find()->where(['user_id' => $userId])->one();
        if (!$statement->countFilesAndCountPagesTrue()) {
            throw new \DomainException('Загружены не все файлы заявления!');
        }
    }


}