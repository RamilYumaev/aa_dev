<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementPersonalDataRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\UserCgRepository;

class StatementPersonalDataService
{
    public $repository;

    public function __construct(StatementPersonalDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($userId)
    {
        if (!$this->repository->get($userId)) {
            $this->repository->save(StatementConsentPersonalData::create($userId));
        }

    }

    public function addCountPages($userId, $count)
    {
        $statement = $this->repository->get($userId);
        if ($statement) {
            if (!$statement->countFilesINSend()) {
                $statement->setCountPages($count);
            }
            $this->repository->save($statement);
        }
    }

    /**
     * @param $userId
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */

    public function remove($userId)
    {
        $model = $this->repository->get($userId);
        if ($model && !$model->countFiles()) {
            $this->repository->remove($model);
        }
    }
}