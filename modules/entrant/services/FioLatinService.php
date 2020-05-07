<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\dictionary\models\DictOrganizations;
use modules\dictionary\repositories\DictOrganizationsRepository;
use modules\entrant\forms\AgreementForm;
use modules\entrant\forms\FIOLatinForm;
use modules\entrant\models\Agreement;
use modules\entrant\models\FIOLatin;
use modules\entrant\repositories\AgreementRepository;
use modules\entrant\repositories\FiOLatinRepository;
use Mpdf\Tag\Tr;

class FioLatinService
{
    private $repository;

    public function __construct(FiOLatinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOrUpdate(FIOLatinForm $form)
    {
        if(($model = $this->repository->getUser($form->user_id)) !== null) {
            $model->data($form);
        }else {
            $model= FIOLatin::create($form);
        }
        $this->repository->save($model);
    }



}