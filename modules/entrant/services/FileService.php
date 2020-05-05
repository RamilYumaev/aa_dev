<?php


namespace modules\entrant\services;

use modules\entrant\forms\FileForm;
use modules\entrant\models\File;
use modules\entrant\models\Statement;
use modules\entrant\repositories\FileRepository;
use yii\db\BaseActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Zxing\QrReader;

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
            $this->correctImageFile($form->file_name);
            $model  = File::create($form->file_name, $form->user_id, $model::className(), $model->id);
            $this->repository->save($model);
            if($model->model = Statement::class) {
                $this->statement($model);
            }
        }
        return null;
    }

    public function correctImageFile(UploadedFile $file) {
        $array = ["image/png", 'image/jpeg'];
        $type = FileHelper::getMimeType($file->tempName, null, false);
        if (!in_array($type, $array)) {
            throw new \DomainException('Неверный тип файла '.$file->type.'.  Ваш файл - '.$type);
        }
    }

    private function statement(File $model) {
        $QRCodeReader = new QrReader($model->getUploadedFilePath('file_name_user'));
        $text =$QRCodeReader->text();
        if(!$text) {
            $this->remove($model->id);
            throw new \DomainException('Qr-code не найден');
        } else {
            $data = explode("-", $text);
            if($data[0] != $model->record_id) {
                $this->remove($model->id);
                throw new \DomainException('Данный Qr-code не принадлежт к заявлению');
            }elseif ($this->repository->getFullFile($model->user_id, $model->model,
                $model->record_id, $data[1])){
                $this->remove($model->id);
                throw new \DomainException('Файл заявления присутсвует');
            } else {
                $model->setPosition($data[1]);
                $this->repository->save($model);
            }
        }
    }

    public function edit($id, FileForm $form)
    {
        $model = $this->repository->get($id);
        if($form->file_name) {
            $this->correctImageFile($form->file_name);
            $model->setFile($form->file_name);
            $this->repository->save($model);
            if($model->model = Statement::class) {
                $this->statement($model);
            }
        }
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }


}