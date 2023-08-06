<?php


namespace modules\entrant\modules\ones\job;


use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class AlternateHandle extends BaseObject implements \yii\queue\JobInterface
{

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        $allPriorities = CompetitiveList::find()
            ->select("priority")
            ->groupBy("priority")
            ->orderBy(['priority'=>SORT_ASC])->column();
        foreach ($allPriorities as $priority) {
            $competitiveLists = CompetitiveList::find()
                ->andWhere(['priority'=> $priority])
                ->andWhere('snils_or_id NOT IN (SELECT snils_or_id FROM competitive_list_ones WHERE status=1)')
                ->all();
            /**
             * @var $competitiveList CompetitiveList
             */
            $check = [];
            foreach ($competitiveLists as $competitiveList) {
                $newStatus = $this->contest($competitiveList->competitiveGroup, $competitiveList->snils_or_id);
                if($this->finishedContest($competitiveList->competitiveGroup)) {
                    echo "dd";
                    continue;
                }

                if ($newStatus == CompetitiveList::STATUS_SUCCESS) {
                    $competitiveList->status = $newStatus;
                    if(!$competitiveList->save()){
                        print_r("Статус заявления не сохранен! " .$competitiveList->firstErrors);
                    }
                        CompetitiveList::updateAll(
                            ['status' => $competitiveList::STATUS_NO_SUCCESS],
                            ['and', ['snils_or_id' => $competitiveList->snils_or_id],
                                ['not', ['id' => $competitiveList->id]]]);
                    }


            }
        }
        $newStatusLists = CompetitiveList::find()->andWhere(['status'=>CompetitiveList::STATUS_NEW])->all();
        /**
         * @var $newStatusList CompetitiveList
         */
            foreach ($newStatusLists as $newStatusList) {
                $this->noSuccessAllCg($newStatusList->snils_or_id);
            }

            if(CompetitiveList::find()->andWhere(['status'=> CompetitiveList::STATUS_NEW])->exists()) {
                Yii::$app->queue->push(new AlternateHandle());
            }
    }

    private function contest(CompetitiveGroupOnes $competitiveGroup, string $snilsOrId) {
        $contest = CompetitiveList::find()
            ->select(['snils_or_id'])
            ->andWhere(['cg_id'=> $competitiveGroup->id])
            ->andWhere(['<>','status', CompetitiveList::STATUS_NO_SUCCESS])
            ->limit($competitiveGroup->kcp)
            ->orderBy(['sum_ball'=> SORT_DESC])
            ->column();
        if(in_array($snilsOrId, $contest)) {
            return CompetitiveList::STATUS_SUCCESS;
        } else {
            return CompetitiveList::STATUS_NEW;
        }
    }
    private function finishedContest(CompetitiveGroupOnes $competitiveGroup){
        $amountOfTransfer = $competitiveGroup->getCountStatuses(CompetitiveList::STATUS_SUCCESS);
        $amountOfNewStatus = $competitiveGroup->getCountStatuses(CompetitiveList::STATUS_NEW);
        if($amountOfTransfer == $competitiveGroup->kcp && $amountOfNewStatus == 0) {
            $competitiveGroup->status = CompetitiveGroupOnes::STATUS_HANDLED;
            if(!$competitiveGroup->save()) {
                print_r("Ошибка сохранения статуса конкурсной группы. " . $competitiveGroup->id);
            }
            return true;
        }
        return false;
    }

    private function noSuccessAllCg(string $snils) {
        $cgId = CompetitiveList::find()->select('cg_id')->andWhere(['snils_or_id'=>$snils])->column();
        $cgs = CompetitiveGroupOnes::find()->andWhere(['in', 'id', $cgId])->all();
        $result = [];
        /**
         * @var $cg CompetitiveGroupOnes
         */
        foreach ($cgs as $cg) {
            if($cg->getCountStatuses(CompetitiveList::STATUS_SUCCESS) == $cg->kcp) {
                $result[] = 0;
            }else {
                $result[] = 1;
            }
        }
        if(array_sum($result) == 0) {
            CompetitiveList::updateAll(['status'=> CompetitiveList::STATUS_NO_SUCCESS], ['snils_or_id'=>$snils]);
        }


    }
}