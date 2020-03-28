<?php


namespace modules\entrant\services;

use modules\entrant\forms\ECPForm;
use modules\entrant\models\ECP;
use modules\entrant\repositories\ECPRepository;
use yii\web\UploadedFile;

class ECPService
{
    private $repository;

    public function __construct(ECPRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ECPForm $form)
    {
        if($form->file_name) {
            $model  = ECP::create($form->file_name, $form->user_id);
            $this->repository->save($model);
            return $model;
        }
        return null;
    }

    public function edit($id, ECPForm $form)
    {
        $model = $this->repository->get($id);
        if($form->file_name) {
            $model->setFile($form->file_name);
        }
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }


}