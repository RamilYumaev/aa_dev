<?php


namespace modules\entrant\services;


use modules\entrant\forms\AdditionalInformationForm;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\InsuranceCertificateUser;
use modules\entrant\repositories\AdditionalInformationRepository;
use modules\entrant\repositories\InsuranceCertificateUserRepository;
use modules\entrant\repositories\StatementRepository;

class AdditionalInformationService
{
    private $repository;
    private $statementRepository;
    private $certificateUserRepository;

    public function __construct(AdditionalInformationRepository $repository, InsuranceCertificateUserRepository $certificateUserRepository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->statementRepository  = $statementRepository;
        $this->certificateUserRepository = $certificateUserRepository;
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
        if($form->insuranceNumber) {
            $this->addOrEditInsuranceCertificate($form->user_id, $form->insuranceNumber);
        }
    }

    public function examCheck(AdditionalInformation $model)
    {
        $model->setExamCheck(1);
        $model->detachBehavior("moderation");
        $this->repository->save($model);
    }

    private function addOrEditInsuranceCertificate($userId, $number) {
       $model = $this->certificateUserRepository->getUser($userId);
       if($model) {
           $model->data($number, $userId);
           if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
               $model->detachBehavior("moderation");
           }
       } else {
           $model = new InsuranceCertificateUser();
           $model->data($number, $userId);
       }

       $this->certificateUserRepository->save($model);
    }


}