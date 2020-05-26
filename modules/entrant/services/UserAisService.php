<?php


namespace modules\entrant\services;

use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisReturnData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\UserAis;
use modules\entrant\repositories\StatementConsentCgRepository;
use modules\entrant\repositories\StatementRepository;
use modules\usecase\RepositoryDeleteSaveClass;
use Mpdf\Tag\Tr;

class UserAisService
{
    private $repository;
    private $transactionManager;
    private $statementRepository;
    private $consentCgRepository;

    public function __construct(RepositoryDeleteSaveClass $repository,
                                TransactionManager $transactionManager,
                                StatementRepository $statementRepository,
                                StatementConsentCgRepository $consentCgRepository)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
        $this->consentCgRepository = $consentCgRepository;
        $this->statementRepository = $statementRepository;
    }

    public function create($userId, $data, $createdId)
    {
        $this->transactionManager->wrap(function () use($userId, $data, $createdId) {
            $model  = UserAis::create($userId, $data['incoming_id']);
            $this->repository->save($model);
            $this->dataAis($data, $createdId, $model->incoming_id);
        });
    }

    public function addData($userId, $data, $createdId, $model, $id)
    {
        $this->transactionManager->wrap(function () use($userId, $data, $createdId,  $model, $id) {
             $this->statusSuccess($model, $id);
             $this->dataAis($data, $createdId, $userId);
        });
    }

    private function dataAis($data,  $createdId, $incomingId) {
        if(key_exists('documents', $data)) {
            foreach($data['documents']  as $type => $value) {
                foreach ($value as  $item) {
                    $aisData = AisReturnData::create($createdId,
                        AisReturnDataHelper::modelKey($type), $type, $incomingId, $item['sdo_id'], $item['ais_id']);
                    $this->repository->save($aisData);
                }
            }
        }
    }

    private function statusSuccess($model, $id) {
        if($model == Statement::class){
            $statement = $this->statementRepository->get($id);
            $statement->setStatus(StatementHelper::STATUS_ACCEPTED);
            $this->statementRepository->save($statement);
        }elseif($model == StatementConsentCg::class) {
            $statement = $this->consentCgRepository->get($id);
            $statement->setStatus(StatementHelper::STATUS_ACCEPTED);
            $this->consentCgRepository->save($statement);
        }
    }

}