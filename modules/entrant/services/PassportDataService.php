<?php
namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\models\PassportData;
use modules\entrant\repositories\PassportDataRepository;

class PassportDataService
{
    private $repository;
    private $transactionManager;

    public function __construct(PassportDataRepository $repository, TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
    }

    public function create(PassportDataForm $form)
    {
        $this->transactionManager->wrap(function () use ($form) {
            $model  = PassportData::create($form, $this->mainStatusDefaultForm($form));
            $this->repository->save($model);
        });

    }

    public function edit($id, PassportDataForm $form)
    {
        $this->transactionManager->wrap(function () use ($id, $form) {
            $model = $this->repository->get($id);
            $model->data($form, $model->main_status);
            $this->repository->save($model);
        });
    }

    private function mainStatusDefaultForm(PassportDataForm $form)
    {
         return PassportData::find()->where(['main_status'=> DictDefaultHelper::YES,'user_id'=> $form->user_id])->exists() ? false :true;
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}