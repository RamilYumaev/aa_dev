<?php

namespace modules\entrant\modules\ones_2024\job;

use modules\entrant\modules\ones_2024\model\CgSS;
use modules\entrant\modules\ones_2024\model\CompetitiveList;
use yii\base\BaseObject;
use yii\queue\Queue;

class FinalHandler extends BaseObject implements \yii\queue\JobInterface
{
    public $arr = [];
    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        $priorities = CompetitiveList::find()
            ->select('priority')
            ->groupBy('priority')
            ->orderBy(['priority'=>SORT_ASC])
            ->column();

        foreach ($priorities as $priority) {
            $allUnhandledApplications = CompetitiveList::find()
                ->andWhere(['priority'=> $priority])
                ->andWhere(['cg_id' => $this->allGgByLevel()])
                ->andWhere(['status'=> CompetitiveList::STATUS_NEW])
                ->orderBy(['sum_ball'=> SORT_DESC])
                ->all();
            /**
             * @var $allUnhandledApplication CompetitiveList
             */
            foreach ($allUnhandledApplications as $allUnhandledApplication) {
                if($this->contest($allUnhandledApplication->cg_id, $allUnhandledApplication->snils_or_id)) {
                    $allUnhandledApplication->status = CompetitiveList::STATUS_SUCCESS;
                    if(!$allUnhandledApplication->save()) {
                        print_r($allUnhandledApplication->firstErrors);
                    }
                    CompetitiveList::updateAll(
                        ['status' => CompetitiveList::STATUS_NO_SUCCESS],
                        ['and', ['snils_or_id' => $allUnhandledApplication->snils_or_id],
                            ['cg_id' => $this->allGgByLevel()],
                            ['>', 'priority', $allUnhandledApplication->priority],
                            ['not', ['id' => $allUnhandledApplication->id]]]);
                }

                $this->setStatusDeficiency($allUnhandledApplication->competitiveGroup);
                $this->setStatusHandled($allUnhandledApplication->competitiveGroup);
            }
        }

        $count = CompetitiveList::find()->andWhere(['status'=> CompetitiveList::STATUS_NEW])
            ->andWhere(['cg_id' => $this->allGgByLevel()])
            ->count();
        $this->arr[] = $count;
        echo $count;
        $result = array_count_values($this->arr);
        if(in_array($count, $this->arr) && $result[$count] > 3) {
            CompetitiveList::updateAll(
                ['status' => CompetitiveList::STATUS_NO_SUCCESS],
                ['status' => CompetitiveList::STATUS_NEW, 'cg_id' => $this->allGgByLevel()]);
        }else {
            \Yii::$app->queue->push(new FinalHandler(['arr' => $this->arr]));
        }
    }

    private function contest(int $cgId, string $snilsOrId){

        $competitiveGroup = CgSS::findOne($cgId);
        $applications = CompetitiveList::find()
            ->select('snils_or_id')
            ->andWhere(['cg_id'=>$cgId])
            ->andWhere(['<>', 'status', CompetitiveList::STATUS_NO_SUCCESS])
            ->orderBy(['number'=> SORT_ASC])
            ->limit($competitiveGroup->kcp)
            ->column();
        return in_array($snilsOrId, $applications);
    }

    private function setStatusDeficiency(CgSS $competitiveGroupOnes) {
        $amountOfAppWithNoSuccessStatus = CompetitiveList::find()
            ->andWhere(['<>','status', CompetitiveList::STATUS_NO_SUCCESS])
            ->andWhere(['cg_id'=> $competitiveGroupOnes->id])
            ->count();
        if($competitiveGroupOnes->kcp > $amountOfAppWithNoSuccessStatus) {
            $competitiveGroupOnes->status = CgSS::STATUS_DEFICIENCY;
            if(!$competitiveGroupOnes->save()) {
                print_r($competitiveGroupOnes->firstErrors);
            }
        }
    }

    private function setStatusHandled(CgSS $competitiveGroupOnes) {
        $amountSuccessStatus = CompetitiveList::find()
            ->andWhere(['status'=> CompetitiveList::STATUS_SUCCESS])
            ->andWhere(['cg_id'=> $competitiveGroupOnes->id])
            ->count();
        if($competitiveGroupOnes->kcp == $amountSuccessStatus) {
            $competitiveGroupOnes->status = CgSS::STATUS_HANDLED;
            if(!$competitiveGroupOnes->save()) {
                print_r($competitiveGroupOnes->firstErrors);
            }
        }
    }

    private function allGgByLevel() {
        return CgSS::find()->andWhere(['type' => 'Основные места в рамках КЦП'])->select('id')->column();
    }
}