<?php


namespace modules\entrant\services;

use common\transactions\TransactionManager;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisReturnData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\UserAis;
use modules\entrant\repositories\StatementConsentCgRepository;
use modules\entrant\repositories\StatementIndividualAchievementsRepository;
use modules\entrant\repositories\StatementRejectionCgConsentRepository;
use modules\entrant\repositories\StatementRepository;
use modules\usecase\RepositoryDeleteSaveClass;
use Mpdf\Tag\Tr;

class UserAisService
{
    private $repository;
    private $transactionManager;
    private $statementRepository;
    private $consentCgRepository;
    private $individualAchievementsRepository;
    private $rejectionCgConsentRepository;

    public function __construct(RepositoryDeleteSaveClass $repository,
                                TransactionManager $transactionManager,
                                StatementRepository $statementRepository,
                                StatementIndividualAchievementsRepository $individualAchievementsRepository,
                                StatementConsentCgRepository $consentCgRepository,
                                StatementRejectionCgConsentRepository $rejectionCgConsentRepository)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
        $this->consentCgRepository = $consentCgRepository;
        $this->statementRepository = $statementRepository;
        $this->individualAchievementsRepository = $individualAchievementsRepository;
        $this->rejectionCgConsentRepository = $rejectionCgConsentRepository;
    }

    public function create($userId, $data, $createdId)
    {
        $this->transactionManager->wrap(function () use($userId, $data, $createdId) {
            $model  = UserAis::create($userId, $data['incoming_id']);
            $this->repository->save($model);
            $this->dataAis($data, $createdId, $model->incoming_id);
        });
    }

    public function addData($model, $id)
    {
        $this->transactionManager->wrap(function () use(  $model, $id) {
             $this->statusSuccess($model, $id);
        });
    }

    public function removeZos($id)
    {
        $this->transactionManager->wrap(function () use($id) {
            $zosRemove  = $this->rejectionCgConsentRepository->get($id);
            $zos = $this->consentCgRepository->get($zosRemove->statement_cg_consent_id);
            $zos->setStatus(StatementHelper::STATUS_RECALL);
            $zosRemove->setStatus(StatementHelper::STATUS_ACCEPTED);


            $this->rejectionCgConsentRepository->save($zosRemove);
            $this->consentCgRepository->save($zos);
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
        }elseif($model == StatementIndividualAchievements::class) {
            $statement = $this->individualAchievementsRepository->get($id);
            $statement->setStatus(StatementHelper::STATUS_ACCEPTED);
            $this->individualAchievementsRepository->save($statement);
        }
    }

}