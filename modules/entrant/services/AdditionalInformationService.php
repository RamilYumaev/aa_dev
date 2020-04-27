<?php


namespace modules\entrant\services;


use modules\entrant\forms\AdditionalInformationForm;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\repositories\AdditionalInformationRepository;

class AdditionalInformationService
{
    private $repository;

    public function __construct(AdditionalInformationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOrUpdate(AdditionalInformationForm $form)
    {
        if(($model = $this->repository->getUser($form->user_id)) !== null) {
            $model->data($form);
        }else {
            $model= AdditionalInformation::create($form);
        }
            $this->repository->save($model);
    }


}