<?php

namespace modules\entrant\widgets\file;
use modules\entrant\helpers\FileHelper;
use yii\base\Widget;
use Yii;

class FileWidget extends Widget
{
    public $model;
    public $record_id;
    public $url = "file/upload";

    public function run()
    {
        return $this->render('button', ['hash' => $this->generateModelHash(), 'link'=>$this->modelLink(),  'url'=> $this->url, 'id' => $this->record_id]);
    }

    public function generateModelHash() {
      return Yii::$app->getSecurity()->encryptByKey($this->record_id, $this->model);
    }
    private function modelLink() {
        return FileHelper::listHash()[$this->model];
    }


}
