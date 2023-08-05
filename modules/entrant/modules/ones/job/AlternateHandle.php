<?php


namespace modules\entrant\modules\ones\job;


use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use phpDocumentor\Reflection\Types\String_;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\queue\Queue;

class AlternateHandle extends BaseObject implements \yii\queue\JobInterface
{

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        CompetitiveGroupOnes::updateAll(['status'=> CompetitiveGroupOnes::STATUS_NEW]);
        CompetitiveList::updateAll(['status'=> CompetitiveList::STATUS_NEW]);
        $allPriorities = CompetitiveList::find()
            ->select("priority")
            ->groupBy("priority")
            ->orderBy(['priority'=>SORT_ASC])->column();
        foreach ($allPriorities as $priority) {
            $competitiveLists = CompetitiveList::find()
                ->andWhere(['priority'=>$priority])
                ->all();
            /**
             * @var $competitiveList CompetitiveList
             */
            foreach ($competitiveLists as $competitiveList) {
                $this->finishedContest($competitiveList->competitiveGroup);
                if($competitiveList->competitiveGroup->status == CompetitiveGroupOnes::STATUS_HANDLED) {
                    continue;
                }
                $newStatus = $this->contest($competitiveList->competitiveGroup, $competitiveList->snils_or_id);
                $competitiveList->status = $newStatus;
                if(!$competitiveList->save()){
                    print_r("Статус заявления не сохранен! " .$competitiveList->firstErrors);
                }
                if ($newStatus == CompetitiveList::STATUS_SUCCESS) {
                        CompetitiveList::updateAll(
                            ['status' => $competitiveList::STATUS_NO_SUCCESS],
                            ['and', ['snils_or_id' => $competitiveList->snils_or_id],
                                ['not', ['id' => $competitiveList->id]]]);
                }
            }
        }
    }

    private function contest(CompetitiveGroupOnes $competitiveGroup, string $snilsOrId) {
        $contest = CompetitiveList::find()
            ->select(['snils_or_id'])
            ->andWhere(['cg_id'=> $competitiveGroup->id])
            ->andWhere(['<>','status', CompetitiveList::STATUS_NO_SUCCESS])
            ->limit($competitiveGroup->kcp)
            ->orderBy(['sum_ball'=> SORT_DESC])->column();
        if(in_array($snilsOrId, $contest)) {
            return CompetitiveList::STATUS_SUCCESS;
        } else {
            return CompetitiveList::STATUS_NO_SUCCESS;
        }
    }
    private function finishedContest(CompetitiveGroupOnes $competitiveGroup){
        $amountOfTransfer = CompetitiveList::find()
            ->andWhere(['cg_id'=>$competitiveGroup->id])
            ->andWhere(['status'=> CompetitiveList::STATUS_SUCCESS])->count();
        if($amountOfTransfer == $competitiveGroup->kcp) {
            $competitiveGroup->status = CompetitiveGroupOnes::STATUS_HANDLED;
            if(!$competitiveGroup->save()) {
                print_r("Ошибка сохранения статуса конкурсной группы. " . $competitiveGroup->id);
            }
        }
    }
}