<?php


namespace modules\entrant\services;

use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\models\AisReturnData;
use modules\entrant\models\UserAis;
use modules\usecase\RepositoryDeleteSaveClass;
use Mpdf\Tag\Tr;

class UserAisService
{
    private $repository;
    private $transactionManager;

    public function __construct(RepositoryDeleteSaveClass $repository, TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
    }

    public function create($userId, $data, $createdId)
    {
        $this->transactionManager->wrap(function () use($userId, $data, $createdId) {
            $model  = UserAis::create($userId, $data['incoming_id']);
            $this->repository->save($model);
            if(key_exists('documents', $data)) {
                foreach($data['documents']  as $type => $value) {
                    foreach ($value as  $item) {
                        foreach ($item as  $sdo => $ais) {
                            $aisData = AisReturnData::create($createdId,
                                AisReturnDataHelper::modelKey($type), $type, $model->incoming_id, $sdo, $ais);
                            $this->repository->save($aisData);
                        }
                    }
                }
            }
        });

    }
}