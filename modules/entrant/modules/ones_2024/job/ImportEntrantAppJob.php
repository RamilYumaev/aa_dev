<?php
namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use modules\entrant\modules\ones_2024\model\EntrantCgAppSS;
use modules\entrant\modules\ones_2024\model\FileSS;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class ImportEntrantAppJob extends BaseObject implements \yii\queue\JobInterface
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
                    if (!EntrantSS::findOne(['quid' => $r[0]])) {
                        $model = new EntrantSS();
                        $model->quid = $r[0];
                        $model->fio = $r[1];
                        $model->sex = $r[2];
                        $model->date_of_birth = date('Y-m-d', strtotime($r[3]));
                        $model->place_of_birth = $r[4];
                        $model->phone = $r[5];
                        $model->email = $r[6];
                        $model->snils = $this->getSnils($r[7]);
                        $model->type_doc = $r[8];
                        $model->series = $r[9];
                        $model->number = $r[10];
                        $model->nationality = $r[11];
                        $model->date_of_issue = date('Y-m-d', strtotime($r[12]));
                        $model->is_hostel = $r[19] == "ИСТИНА";
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
            'quid_statement' => $r[13],
            'quid_cg' => $r[25],
            'quid_profile' => $r[0],
            'quid_cg_competitive' => $r[22],
        ])->one();
        if($model) {
            $model->source = $r[14];
            $model->actual = $r[15];
            $model->datetime = date('Y-m-d H:i:s', strtotime($r[17]));
            $model->priority_vuz = null;
            $model->priority_ss = $r[29];
            $model->status =  $r[30];
            $model->is_el_original = $r[33] == "ИСТИНА";
            $model->is_paper_original = $r[32] == "ИСТИНА";
            if(!$model->save()) {
                var_dump($model->errors);
            }
        }else {
            $model = new EntrantCgAppSS();
            $model->source = $r[14];
            $model->actual = $r[15];
            $model->priority_vuz = null;
            $model->priority_ss = $r[29];
            $model->status = $r[30];
            $model->is_el_original = $r[33] == "ИСТИНА";
            $model->is_paper_original = $r[32] == "ИСТИНА";
            $model->datetime = date('Y-m-d H:i:s', strtotime($r[17]));
            $model->quid_statement = $r[13];
            $model->quid_cg = $r[25];
            $model->quid_profile = $r[0];
            $model->quid_cg_competitive = $r[22];
            if(!$model->save()) {
                var_dump($model->errors);
            }
        }
    }
    public function getSnils($subject) {
        if (preg_match(
            '/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})$/',
            $subject, $value)) {
            return $value[1]."-".$value[2]."-".$value[3]." ".$value[4];
            }
        return  $subject;
    }
}
