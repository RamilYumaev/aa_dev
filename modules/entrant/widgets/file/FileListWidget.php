<?php

namespace modules\entrant\widgets\file;
use modules\entrant\models\File;
use yii\base\Widget;
use Yii;

class FileListWidget extends Widget
{
    public $userId;
    public $model;
    public $view = "list";
    public $record_id;

    public function run()
    {
        return $this->render($this->view, [
            'files' => File::find()->defaultQueryUser($this->userId,
                $this->model,
                $this->record_id)->all()
            ]);
    }


}
