<?php


namespace modules\entrant\services;


use modules\entrant\forms\FIOLatinForm;
use modules\entrant\models\FIOLatin;
use modules\entrant\repositories\FiOLatinRepository;
use modules\entrant\repositories\StatementRepository;
use Mpdf\Tag\Tr;

class FioLatinService
{
    private $repository;
    private $statementRepository;

    public function __construct(FiOLatinRepository $repository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->statementRepository = $statementRepository;
    }

    public function createOrUpdate(FIOLatinForm $form)
    {
        if(($model = $this->repository->getUser($form->user_id)) !== null) {
            $model->data($form);
            if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
                $model->detachBehavior("moderation");
            }
        }else {
            $model= FIOLatin::create($form);
        }
        $this->repository->save($model);
    }



}