<?php


namespace modules\transfer\services;

use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\models\Address;
use modules\entrant\models\PassportData;
use modules\exam\models\Exam;
use modules\transfer\helpers\ContractHelper;
use modules\transfer\models\File;
use modules\transfer\models\PacketDocumentUser;
use modules\transfer\models\PassExam;
use modules\transfer\models\PassExamProtocol;
use modules\transfer\models\PassExamStatement;
use modules\transfer\models\StatementAgreementContractTransferCg;
use modules\transfer\models\StatementConsentPersonalData;
use modules\transfer\models\StatementTransfer;

class SubmittedDocumentsService
{
    private $manager;



    public function __construct(TransactionManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $user_id
     * @throws \Exception
     */

    public function transferSend($user_id)
    {
        $this->manager->wrap(function () use ($user_id) {
            $this->statementPd($user_id);
            $this->passport($user_id);
            $this->address($user_id);
            $this->statementTransfer($user_id);
            $this->packetDocument($user_id);
            $this->files($user_id);
        });
    }

    public function transferContractSend($user_id)
    {
        $this->manager->wrap(function () use ($user_id) {
            $this->contractTransfer($user_id);
        });
    }

    public function examSend($userId)
    {
        $files = File::find()->model([PassExamProtocol::class, PassExamStatement::class])->user($userId)->status([FileHelper::STATUS_ACCEPTED])->all();
            /* @var $statement \modules\entrant\models\File */
        foreach ($files as $file) {
            $file->setStatus(FileHelper::STATUS_SEND);
            $file->save($file);
        }
    }


    private function files($userId)
    {
        $files = File::find()->user($userId)->status(FileHelper::STATUS_DRAFT)->all();
        /* @var $statement \modules\entrant\models\File */
        foreach ($files as $file) {
            $file->setStatus(FileHelper::STATUS_WALT);
            $file->save($file);
        }
    }

    private function address($userId)
    {
        $others = Address::find()->where(['user_id' => $userId, 'type' => [AddressHelper::TYPE_REGISTRATION, AddressHelper::TYPE_RESIDENCE]])->all();
        /* @var $other \modules\entrant\models\Address */
        foreach ($others as $other) {
            if (!$other->transferFiles) {
                throw new \DomainException(' Не загружен файл(-ы) раздела "Адреса" к типу ' . $other->typeName . '!');
            }
        }
    }

    private function passport($userId)
    {
        $other = PassportData::find()->where(['user_id' => $userId, 'main_status' => true])->one();
        if (!$other->filesTransfer) {
            throw new \DomainException(' Не загружен файл(-ы) раздела "Паспортные данные" к типу ' . $other->typeName . '!');
        }
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
        if(!$statement->status || $statement->statusNoAccepted()) {
            $statement->setStatus(FileHelper::STATUS_WALT);
            $statement->save();
        }
    }

    private function contractTransfer($userId)
    {
        /** @var StatementAgreementContractTransferCg $statement */
        $statement = StatementAgreementContractTransferCg::
        find()->joinWith("statementTransfer.passExam")
            ->andWhere(['finance'=> DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT])
            ->andWhere(['user_id'=> $userId,
                'success_exam'=> PassExam::SUCCESS])->one();
        if($statement->statusDraft()) {
            if ($statement->typePersonal()) {
                if (!$statement->personal->countFiles()) {
                    throw new \DomainException(' Не загружены файлы!');
                } else {
                    foreach ($statement->personal->files as $file) {
                        $file->setStatus(FileHelper::STATUS_WALT);
                        $file->save($file);
                    }
                }
            }
            if ($statement->typeLegal()) {
                if (!$statement->legal->countFiles()) {
                    throw new \DomainException('Не загружены файлы!');
                } else {
                    foreach ($statement->legal->files as $file) {
                        $file->setStatus(FileHelper::STATUS_WALT);
                        $file->save($file);
                    }
                }
            }
            $statement->status_id = FileHelper::STATUS_WALT;
        }

        if($statement->statusCreated() ||  $statement->statusNoAccepted()) {
            if ($statement->countFiles() < 3) {
                throw new \DomainException('Не загружены файлы!');
            }
            foreach ($statement->files as $file) {
                $file->setStatus(FileHelper::STATUS_WALT);
                $file->save($file);
            }
            $statement->status_id = ContractHelper::STATUS_ACCEPTED_STUDENT;
        }

        if($statement->statusGroupAccepted() && $receipt = $statement->receiptContract) {
            if (!$receipt->countFiles()) {
                throw new \DomainException('Не загружены файлы квитанции!');
            }
            foreach ($receipt->files as $file) {
                $file->setStatus(FileHelper::STATUS_WALT);
                $file->save($file);
            }
            $receipt->status_id = ContractHelper::STATUS_WALT;
            $receipt->save();
        }

        $statement->save(false);
    }



    private function statementPd($userId)
    {
        $statement = StatementConsentPersonalData::find()->where(['user_id' => $userId])->one();
        if (!$statement->countFilesAndCountPagesTrue()) {
            throw new \DomainException('Загружены не все файлы заявления!');
        }
    }



}