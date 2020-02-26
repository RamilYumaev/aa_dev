<?php


namespace modules\entrant\services;

use modules\entrant\forms\AddressForm;
use modules\entrant\models\Address;
use modules\entrant\repositories\AddressRepository;

class AddressService
{
    private $repository;

    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
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
        $model->save($model);
    }

    public function remove($id)
    {

    }
}