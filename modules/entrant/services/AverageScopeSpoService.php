<?php


namespace modules\entrant\services;


use modules\entrant\forms\AverageScopeSpoForm;
use modules\entrant\models\AverageScopeSpo;
use modules\entrant\repositories\AverageScopeSpoRepository;
use modules\entrant\repositories\StatementRepository;

class AverageScopeSpoService
{
    private $repository;
    private $statementRepository;

    public function __construct(AverageScopeSpoRepository $repository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->statementRepository  = $statementRepository;
    }

    public function createOrUpdate(AverageScopeSpoForm $form)
    {
        if(($model = $this->repository->getUser($form->user_id)) !== null) {
            $model->data($form);
            if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
                $model->detachBehavior("moderation");
            }
        }else {
            $model= AverageScopeSpo::create($form);
        }
            $this->repository->save($model);
    }
}