<?php


namespace modules\entrant\services;

use common\transactions\TransactionManager;
use modules\entrant\forms\BaseMessageForm;
use modules\entrant\forms\FileForm;
use modules\entrant\forms\FileMessageForm;
use modules\entrant\helpers\FileHelper;
use modules\entrant\models\File;
use yii\helpers\FileHelper as IfFile;
use modules\entrant\repositories\FileRepository;
use yii\db\BaseActiveRecord;
use yii\web\UploadedFile;
use Zxing\QrReader;

class FileService
{
    private $repository;

    private $manager;

    public function __construct(FileRepository $repository, TransactionManager $manager)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function create(FileForm $form, BaseActiveRecord $model)
    {
        $this->manager->wrap(function ()use ($form, $model) {
        if($form->file_name) {
            $this->correctImageFile($form->file_name);
            if (FileHelper::listCountModels()[$model::className()]) {
                $arrayCount = FileHelper::listCountModels()[$model::className()];
            } else {
                $arrayCount = $model->count_pages;
            }
            $true = $arrayCount == $this->repository->getFileCount($form->user_id, $model::className(), $model->id);
                if($true) {
                    throw new \DomainException('Загрузка невозможна');
                }
            $modelFile  = File::create($form->file_name, $form->user_id, $model::className(), $model->id);
            $this->repository->save($modelFile);

        }});
        return null;
    }

    public function correctImageFile(UploadedFile $file) {
        $array = ["image/png", 'image/jpeg'];
        $type = IfFile::getMimeType($file->tempName, null, false);
        if (!in_array($type, $array)) {
            throw new \DomainException('Неверный тип файла, разрешено загружать только файлы с расширением jpg');
        }
    }

    public function edit($id, FileForm $form)
    {
        $model = $this->repository->get($id);
        if($form->file_name) {
            $this->correctImageFile($form->file_name);
            $model->setFile($form->file_name);
            $this->repository->save($model);
        }
    }

    public function addMessage($id, FileMessageForm $form)
    {
        $model = $this->repository->get($id);
        $model->setMessage($form->message);
        $model->setStatus(FileHelper::STATUS_NO_ACCEPTED);
        $this->repository->save($model);
    }

    public function accepted($id)
    {
        $model = $this->repository->get($id);
        $model->setStatus(FileHelper::STATUS_ACCEPTED);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }


}