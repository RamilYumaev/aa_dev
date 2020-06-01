<?php


namespace modules\entrant\services;

use modules\entrant\forms\AddressForm;
use modules\entrant\models\Address;
use modules\entrant\repositories\AddressRepository;
use modules\entrant\repositories\StatementRepository;

class AddressService
{
    private $repository;
    private $statementRepository;

    public function __construct(AddressRepository $repository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->statementRepository = $statementRepository;
    }

    public function create(AddressForm $form)
    {
        $model  = Address::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, AddressForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
            $model->detachBehavior("moderation");
        }
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->getFilesExits($model->user_id);
        $this->repository->remove($model);
    }

    public function copy($id, $type)
    {
        $model = $this->repository->get($id);
        $form = new AddressForm($model->user_id, $model);
        $form->type = $type;
        $this->repository->save(Address::create($form));
    }

}