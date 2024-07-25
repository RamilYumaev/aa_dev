<?php
namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use modules\entrant\modules\ones_2024\model\EntrantCgAppSS;
use modules\entrant\modules\ones_2024\model\FileSS;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class ImportEntrantPriorityAppJob extends BaseObject implements \yii\queue\JobInterface
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
        if(file_exists($filePath)) {
            $xlsx = SimpleXLSX::parse(Yii::getAlias($filePath));
            if ($xlsx->success()) {
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }
                    if (!EntrantSS::findOne(['quid' => $r[8]])) {
                        $model = new EntrantSS();
                        $model->quid = $r[8];
                        $model->fio =  $r[2]." ".$r[3]." ".$r[4];
                        $model->snils = $r[5];
                        if (!$model->save()) {
                            var_dump($model->errors);
                        } else {
                            $this->addApplication($r);
                        }
                    } else {
                        $this->addApplication($r);
                    }
                }
            } else {
                echo 'xlsx error: ' . $xlsx->error();
            }
        }
    }
    private function addApplication(array $r) {
        /** @var EntrantCgAppSS $model */
        $model = EntrantCgAppSS::find()->where([
            'quid_statement' => $r[9],
            'quid_cg' => $r[13],
            'quid_profile' => $r[8],
            'quid_cg_competitive' => $r[12],
        ])->one();
        if($model) {
            $model->status = $r[20] == 'Получено вузом' ? 'На рассмотрении' : $r[20];
            $model->priority_ss = $r[18];
            $model->priority_vuz = $r[19];
            if(!$model->save()) {
                var_dump($model->errors);
            }
        } else {
            $model = new EntrantCgAppSS();
            $model->status = $r[20] == 'Получено вузом' ? 'На рассмотрении' : $r[20];
            $model->source = "1c";
            $model->priority_ss = $r[18];
            $model->priority_vuz = $r[19];
            $model->quid_statement = $r[9];
            $model->quid_cg = $r[13];
            $model->quid_profile = $r[8];
            $model->quid_cg_competitive = $r[12];
            if(!$model->save()) {
                var_dump($model->errors);
            }
        }
    }

    public function getSnils() {
        preg_match(
            '/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})$/',
            '19986897194', $value);
        echo $value[1]."-".$value[2]."-".$value[3]." ".$value[4];
    }
}