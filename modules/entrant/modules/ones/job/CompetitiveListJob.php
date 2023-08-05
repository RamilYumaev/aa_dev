<?php
namespace modules\entrant\modules\ones\job;

use modules\entrant\modules\ones\components\ecxel\SimpleXLSX;
use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use yii\base\BaseObject;
use yii\queue\Queue;

class CompetitiveListJob extends BaseObject implements \yii\queue\JobInterface
{
    /*  @var CompetitiveGroupOnes */
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
            if ($xlsx = SimpleXLSX::parse($filePath)) {
                if(CompetitiveList::find()->andWhere(['cg_id' => $this->model->id])->exists()) {
                    CompetitiveList::deleteAll(['cg_id' => $this->model->id]);
                }
                foreach ($xlsx->rows() as $k => $r) {
                    if ($k === 0) {
                        continue;
                    }

                    if ($r[3] == "Да" || $r[4] == "Да") {
                        $model = new CompetitiveList();
                        $model->cg_id = $this->model->id;
                        $model->fio = $r[2];
                        $model->snils_or_id = (string)$r[1];
                        $model->priority = $r[5];
                        $model->sum_ball = $r[6];
                        $model->exam_1 = $r[7];
                        $model->ball_exam_1 = $r[8];
                        $model->exam_2 = $r[9];
                        $model->ball_exam_2 = $r[10];
                        $model->exam_3 = $r[11];
                        $model->ball_exam_3 = $r[12];
                        $model->mark_ai = $r[14];
                        $model->status = CompetitiveList::STATUS_NEW;
                        if (!$model->save()) {
                            print_r($model->firstErrors);
                        }
                    }
                }

            }
        }
    }
}