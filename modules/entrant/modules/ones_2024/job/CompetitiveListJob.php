<?php
namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\model\CompetitiveList;
use modules\entrant\modules\ones_2024\model\CgSS;
use yii\base\BaseObject;
use yii\queue\Queue;

class CompetitiveListJob extends BaseObject implements \yii\queue\JobInterface
{
    /*  @var CgSS */
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

        CompetitiveList::deleteAll(['cg_id' => $this->model->id]);
        $i = 1;
        foreach ($this->model->getListForCompetitive() as $key => $item) {
            $model = new CompetitiveList();
            $model->cg_id = $this->model->id;
            $model->fio = $item['fio'];
            $model->snils_or_id = $item['snils_number'];
            $model->priority = $item['priority'];
            $model->sum_ball = $item['sum_ball'];
            $model->ball_exam_1 = $item['exam_1'];
            $model->ball_exam_2 = $item['exam_2'];
            $model->ball_exam_3 = $item['exam_3'];
            if ($item['name_exams']) {
                $exams =  str_replace([' + '], '', $item['name_exams']);
                $data =  explode(')', $exams);

                foreach ($data as $k => $exam) {
                    if($exam == '') {
                        continue;
                    }
                    $model->{'exam_'.($k+1)}=  $exam.')';;
                }
            }
            $model->mark_ai = $item['sum_individual'];
            $model->number = $i;
            $model->status = CompetitiveList::STATUS_NEW;
            if (!$model->save()) {
                print_r($model->firstErrors);
            }
            $i++;
        }
    }
}