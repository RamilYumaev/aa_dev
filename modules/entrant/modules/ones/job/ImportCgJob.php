<?php
namespace modules\entrant\modules\ones\job;

use modules\entrant\modules\ones\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class ImportCgJob extends BaseObject implements \yii\queue\JobInterface
{
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
        $xlsx = SimpleXLSX::parse(Yii::getAlias($this->path));
        echo  Yii::getAlias($this->path);
        if ($xlsx->success()) {
            foreach ($xlsx->rows() as $k => $r) {
                if ($k === 0) {
                    continue;
                }
                if(!$model = CompetitiveGroupOnes::findOne(['name' => $r[3]])) {
                    $model = new CompetitiveGroupOnes();
                    $model->quid = $r[0];
                    $model->department = $r[1];
                    $model->profile = $r[2];
                    $model->name = $r[3];
                    $model->speciality = $r[4]." - ".$r[5];
                    $model->education_level = $r[6];
                    $model->education_form = $r[7];
                    $model->type_competitive = $r[8];
                    $model->status = $model::STATUS_NEW;
                    if($model->save()){
                        $id = $model->id;
                    }
                }
            }
        } else {
            echo 'xlsx error: '.$xlsx->error();
        }
    }
}