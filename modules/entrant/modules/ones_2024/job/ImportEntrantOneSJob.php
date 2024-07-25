<?php
namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use modules\entrant\modules\ones_2024\model\FileSS;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class ImportEntrantOneSJob extends BaseObject implements \yii\queue\JobInterface
{

    /*  @var FileSS */
    public $model;
    public $path;
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
        $filePath = $this->path ? Yii::getAlias($this->path) : $this->model->getUploadedFilePath('file_name');
        if (file_exists($filePath)) {
            $xlsx = SimpleXLSX::parse(Yii::getAlias($filePath));
            if ($xlsx->success()) {
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }
                    if (!EntrantSS::findOne(['snils' => $r[7]])) {
                        $model = new EntrantSS();
                        $model->quid = '';
                        $model->fio = $r[1];
                        $model->sex = $r[2];
                        $model->date_of_birth = date('Y-m-d', strtotime($r[3]));
                        $model->place_of_birth = $r[4];
                        $model->phone = $r[5];
                        $model->email = $r[6];
                        $model->snils = $r[7];
                        $model->type_doc = $r[8];
                        $model->series = $r[9];
                        $model->number = $r[10];
                        $model->nationality = $r[11];
                        $model->date_of_issue = date('Y-m-d', strtotime($r[12]));
                        $model->division_code = $r[13];
                        $model->is_hostel = $r[14] == "Да";
                        if (!$model->save()) {
                            var_dump($model->errors);
                        }
                    }
                }
            } else {
                echo 'xlsx error: ' . $xlsx->error();
            }
        }
    }
}
