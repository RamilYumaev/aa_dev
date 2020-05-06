<?php

namespace modules\entrant\widgets\file;
use modules\entrant\models\File;
use yii\base\Widget;
use Yii;

class FileListWidget extends Widget
{
    public $model;
    public $record_id;

    public function run()
    {
        return $this->render('list', [
            'files' => File::find()->defaultQueryUser(Yii::$app->user->identity->getId(),
                $this->model,
                $this->record_id)->all()
            ]);
    }


}