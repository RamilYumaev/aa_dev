<?php


namespace modules\entrant\services;

use modules\entrant\forms\FileForm;
use modules\entrant\models\File;
use modules\entrant\repositories\FileRepository;
use yii\db\BaseActiveRecord;
use yii\helpers\FileHelper;

class FileService
{
    private $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(FileForm $form, BaseActiveRecord $model)
    {
        if($form->file_name) {
            $array = ["image/png", 'image/jpeg'];
            $type = FileHelper::getMimeType($form->file_name->tempName, null, false);
            if (!in_array($type, $array)) {
                throw new \DomainException('Неверный тип файла '.$form->file_name->type.'.  Ваш файл - '.$type);
            }
            $model  = File::create($form->file_name, $form->user_id, $model::className(), $model->id);
            $this->repository->save($model);
            return $model;
        }
        return null;
    }

    public function edit($id, FileForm $form)
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