<?php

namespace modules\entrant\widgets\file;
use yii\base\Widget;
use Yii;

class FileWidget extends Widget
{
    public $model;
    public $record_id;

    public function run()
    {
        return $this->render('button', ['hash' => $this->generateModelHash(), 'id' => $this->record_id]);
    }

    public function generateModelHash() {
      return Yii::$app->getSecurity()->encryptByKey($this->record_id, $this->model);
    }


}
