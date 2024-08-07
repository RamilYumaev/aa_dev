<?php
namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones_2024\model\EntrantCgAppSS;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use modules\entrant\modules\ones_2024\model\FileSS;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class ImportOriginalSsJob extends BaseObject implements \yii\queue\JobInterface
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
            $xlsx = SimpleXLSX::parse($filePath);
            if ($xlsx->success()) {
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }
                    if ($model = EntrantSS::findOne(['quid' => $r[0]])) {
                        if($r[2] == "Подан") {
                            if( $r[4] == "ФГБОУ ВО МПГУ") {
                                $data = ['is_el_original' => $r[3] == "Онлайн через ЕПГУ" ? 1 : 0,
                                    'is_paper_original' =>  $r[3] == "Очно в ВУЗ" ? 1 : 0,
                                    'vuz_original' => $r[4]];
                            } else {
                                $data = ['is_el_original' => $r[3] == "Онлайн через ЕПГУ" ? 1 : 0,
                                    'is_paper_original' =>  $r[3] == "Очно в ВУЗ" ? 1 : 0];
                            }
                        } else {
                            $data = ['is_el_original' =>  0, 'is_paper_original' =>  0];
                        }
                        EntrantCgAppSS::updateAll($data, ['quid_profile'=> $model->quid]);
                    } else {
                        echo  'Нет в базе - '.$r[0].PHP_EOL;
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