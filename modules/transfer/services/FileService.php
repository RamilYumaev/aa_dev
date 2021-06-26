<?php


namespace modules\transfer\services;

use modules\entrant\forms\FileMessageForm;
use modules\entrant\helpers\FileHelper;
use modules\transfer\models\File;

class FileService
{

    public function addMessage($id, File $form)
    {
        $model = $this->get($id);
        $model->setMessage($form->message);
        $model->setStatus(FileHelper::STATUS_NO_ACCEPTED);
        $model->save();
    }

    public function accepted($id)
    {
        $model = $this->get($id);
        $model->setStatus(FileHelper::STATUS_ACCEPTED);
        $model->setMessage(null);
        $model->save();
    }

    public function get($id): File
    {
        if (!$model = File::findOne($id)) {
            throw new \DomainException('Файл не найден.');
        }
        return $model;
    }
}