<?php


namespace modules\entrant\modules\ones\job;


use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use phpDocumentor\Reflection\Types\String_;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\queue\Queue;

class CheckNoHandle extends BaseObject implements \yii\queue\JobInterface
{
    public $checks = [];
    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        $competitiveLists = CompetitiveList::find()
            ->andWhere(['id'=> $this->checks])
            ->andWhere(['status' => CompetitiveList::STATUS_NEW])
            ->orderBy(['priority'=>SORT_ASC])
            ->all();

        /**
         * @var $competitiveList CompetitiveList
         */
        foreach ($competitiveLists as $competitiveList) {
            $newStatus = $this->contest($competitiveList->competitiveGroup, $competitiveList->snils_or_id);
            if($this->finishedContest($competitiveList->competitiveGroup)
                && $newStatus == CompetitiveList::STATUS_SUCCESS) {
                continue;
            }
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
            return CompetitiveList::STATUS_NO_SUCCESS;
        }
    }
    private function finishedContest(CompetitiveGroupOnes $competitiveGroup){
        $amountOfTransfer = $competitiveGroup->getCountStatuses(CompetitiveList::STATUS_SUCCESS);
        if($amountOfTransfer == $competitiveGroup->kcp) {
            $competitiveGroup->status = CompetitiveGroupOnes::STATUS_HANDLED;
            if(!$competitiveGroup->save()) {
                print_r("Ошибка сохранения статуса конкурсной группы. " . $competitiveGroup->id);
            }else {
                CompetitiveList::updateAll(
                    ['status' => CompetitiveList::STATUS_NO_SUCCESS],
                    ['and', ['cg_id' => $competitiveGroup->id, 'status' => CompetitiveList::STATUS_NEW]]);
                return true;
            }
        }
        return false;
    }
}