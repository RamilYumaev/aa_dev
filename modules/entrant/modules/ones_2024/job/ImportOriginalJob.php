<?php
namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use modules\entrant\modules\ones_2024\model\FileSS;
use yii\base\BaseObject;
use yii\queue\Queue;

class ImportOriginalJob extends BaseObject implements \yii\queue\JobInterface
{
    /*  @var FileSS */
    public $model;

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function execute($queue)
    {
        \ini_set('memory_limit', '8000M');
        \proc_nice(10);
        \setlocale(LC_COLLATE, 'ru_RU.UTF-8');
        set_time_limit(6000);
        $filePath = $this->model->getUploadedFilePath('file_name');
        if(file_exists($filePath)) {
            EntrantSS::updateAll($this->model->type == $this->model::FILE_UPDATE_ORIGINAL ? ['is_original'=> 0] : ['is_remote_original'=> 0]);
            $xlsx = SimpleXLSX::parse($filePath);
            if ($xlsx->success()) {
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }
                    $snils = $this->getSnils($r[0]);
                    if ($model = EntrantSS::find()->andWhere(['quid' => $r[0]])
                        ->orWhere(['snils' => $snils])->one()) {
                        if ($this->model->type == $this->model::FILE_UPDATE_ORIGINAL) {
                            $model->is_original = true;
                        } else {
                            $model->is_remote_original = true;
                        }

                        if (!$model->save()) {
                            var_dump($model->errors);
                        };
                    }else {
                        echo  'Нет в базе - '.$snils;
                    }
                }
            } else {
                echo 'xlsx error: ' . $xlsx->error();
            }
        }
    }

    public function getSnils($subject)
    {   $data = str_replace(['-', ' '], '', trim($subject));
        if (preg_match(
            '/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})$/',
            $data, $value)) {
            return $value[1]."-".$value[2]."-".$value[3]." ".$value[4];
        }
        return  $subject;
    }
}