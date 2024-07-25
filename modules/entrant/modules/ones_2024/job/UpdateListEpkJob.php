<?php
namespace modules\entrant\modules\ones_2024\job;
use modules\entrant\modules\ones_2024\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones_2024\model\CgSS;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class UpdateListEpkJob extends BaseObject implements \yii\queue\JobInterface
{

    /** @var CgSS */

    public $model;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\Exception
     */

    public function execute($queue)
    {
        \ini_set('memory_limit', '8000M');
        \proc_nice(10);
        \setlocale(LC_COLLATE, 'ru_RU.UTF-8');
        set_time_limit(6000);
        $filePath = $this->model->getUploadedFilePath('file');
        $json = file_get_contents($this->model->getPathFullEpk() . '/' . $this->model->getFileFok());
        if($json) {
            $data = json_decode($json, true);
        }
        $columns = [
            'number',
            'fio',
            'phone',
            'snils_number',
            'exam_1',
            'exam_2',
            'exam_3',
            'sum_exams',
            'sum_individual',
            'sum_ball',
            'name_exams',
            'is_first_status',
            'status_ss',
            'priority',
            'priority_ss',
            'is_ss',
            'is_epk',
            'original',
            'document',
            'is_paper_original_ss',
            'is_el_original_ss',
            'is_hostel',
            'quid_profile',
            'right',
            'is_pay',
            'document_target',
            'organization'];

        if(file_exists($filePath)) {
            $xlsx = SimpleXLSX::parse($filePath);
            if ($xlsx->success()) {
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }
                    $number = array_column($data, 'snils_number');
                    $key = array_search(trim($r[3]), $number);
                    if (is_int($key)) {
                        foreach ($columns as $keyItem => $column) {
                            $data[$key][$column] = $r[$keyItem];
                            $data[$key]['is_change'] = 1;                        }
                    } else {
                        $data[$key]['is_change'] = 1;
                        $newData = [];
                        foreach ($columns as $keyItem => $column) {
                            $newData[$column] = $r[$keyItem];
                        }
                        $data[] = $newData;
                    }
                }
                ArrayHelper::multisort($data, ['sum_ball', 'is_first_status'], [SORT_DESC, SORT_DESC]);
                file_put_contents($this->model->getPathFullEpk() . '/' . $this->model->getFileFok(), json_encode($data));
            }
        }
    }
}