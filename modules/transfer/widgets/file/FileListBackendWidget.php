<?php

namespace modules\transfer\widgets\file;
use modules\entrant\models\File;
use yii\base\Widget;

class FileListBackendWidget extends Widget
{
    public $userId;
    public $model;
    public $view = "list-backend-statement";
    public $isCorrect;
    public $record_id;

    public function run()
    {
        return $this->render($this->view, [
            'isCorrect'=> $this->isCorrect,
            'files' => File::find()->defaultQueryUser($this->userId,
                $this->model,
                $this->record_id)->all()
            ]);
    }


}
