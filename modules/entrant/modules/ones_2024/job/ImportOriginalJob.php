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
            $xlsx = SimpleXLSX::parse($filePath);
            if ($xlsx->success()) {
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }
                    EntrantSS::updateAll(['is_original'=>0]);
                    if ($model = EntrantSS::findOne(['quid' => $r[0]])) {
                        $model->is_original = true;
                        if (!$model->save()) {
                            var_dump($model->errors);
                        };
                    }
                }
            } else {
                echo 'xlsx error: ' . $xlsx->error();
            }
        }
    }
}