<?php


namespace modules\transfer\services;

use common\transactions\TransactionManager;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\models\Address;
use modules\entrant\models\PassportData;
use modules\transfer\models\File;
use modules\transfer\models\PacketDocumentUser;
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
    }

    private function statementPd($userId)
    {
        $statement = StatementConsentPersonalData::find()->where(['user_id' => $userId])->one();
        if (!$statement->countFilesAndCountPagesTrue()) {
            throw new \DomainException('Загружены не все файлы заявления!');
        }
    }



}