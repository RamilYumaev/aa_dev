<?php


namespace modules\entrant\services;


use modules\entrant\forms\AdditionalInformationForm;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\repositories\AdditionalInformationRepository;
use modules\entrant\repositories\StatementRepository;

class AdditionalInformationService
{
    private $repository;
    private $statementRepository;

    public function __construct(AdditionalInformationRepository $repository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->statementRepository  = $statementRepository;
    }

    public function createOrUpdate(AdditionalInformationForm $form)
    {
        if(($model = $this->repository->getUser($form->user_id)) !== null) {
            $model->data($form);
            if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
                $model->detachBehavior("moderation");
            }
        }else {
            $model= AdditionalInformation::create($form);
        }
            $this->repository->save($model);
    }


}