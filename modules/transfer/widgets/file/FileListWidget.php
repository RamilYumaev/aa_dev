<?php

namespace modules\transfer\widgets\file;
use modules\entrant\helpers\FileHelper;
use modules\transfer\models\File;
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
                $this->record_id)->all(),
            'link'=>$this->modelLink(),
            'id' => $this->record_id,
        ]);
    }

    private function modelLink() {
        return FileHelper::listHash()[$this->model];
    }


}
