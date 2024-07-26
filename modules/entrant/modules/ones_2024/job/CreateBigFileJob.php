<?php
namespace modules\entrant\modules\ones_2024\job;

use common\components\TbsWrapper;
use modules\entrant\modules\ones_2024\model\CgSS;
use yii\base\BaseObject;
use yii\queue\Queue;

class CreateBigFileJob extends BaseObject implements \yii\queue\JobInterface
{
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
        \ini_set('memory_limit', '8000M');

        $filePath = \Yii::getAlias('@common') . '/file_templates/list_ss_all.xlsx';

        $data = [];

        $fileName = "all-list.xlsx";

        $file = \Yii::getAlias('@modules').'/entrant/files/ss/'.$fileName;

        if(file_exists($file)) {
            unlink($file);
        }

        /**
         * @var $item CgSS
         */

        foreach (CgSS::find()->all() as $key => $item) {
            if ($item->getListCount()) {
                $data[$key]['name'] = $item->name . " - " . $item->faculty->full_name;
                $data[$key]['table'] = $item->getList();
            }
        }

        $tbs = new TbsWrapper();
        $tbs->openTemplate($filePath);
        $tbs->merge('list', $data);
        $tbs->saveAsFile($file);
    }
}