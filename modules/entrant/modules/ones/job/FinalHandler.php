<?php


namespace modules\entrant\modules\ones\job;


use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
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
                            ['>', 'priority', $allUnhandledApplication->priority],
                            ['not', ['id' => $allUnhandledApplication->id]]]);
                }

                $this->setStatusDeficiency($allUnhandledApplication->competitiveGroup);
                $this->setStatusHandled($allUnhandledApplication->competitiveGroup);
            }
        }

        $count = CompetitiveList::find()->andWhere(['status'=> CompetitiveList::STATUS_NEW])->count();
        $this->arr[] = $count;
        $result = array_count_values($this->arr);
        if(in_array($count, $this->arr) && $result[$count] > 4) {
            CompetitiveList::updateAll(
                ['status' => CompetitiveList::STATUS_NO_SUCCESS],
                ['status' => CompetitiveList::STATUS_NEW]);
        }else {
            \Yii::$app->queue->push(new FinalHandler(['arr'=>$this->arr]));
        }
    }

    private function alReadySuccess(CompetitiveList $competitiveList) {
        return CompetitiveList::find()
            ->andWhere(['snils_or_id'=> $competitiveList->snils_or_id])
            ->andWhere(['status'=> CompetitiveList::STATUS_SUCCESS])
            ->exists();
    }

    private function allCompetitiveGroupsClosed() {
        return !CompetitiveGroupOnes::find()->andWhere(['status'=> CompetitiveGroupOnes::STATUS_NEW])->exists();
    }

    private function contest(int $cgId, string $snilsOrId){

        $competitiveGroup = CompetitiveGroupOnes::findOne($cgId);
        $applications = CompetitiveList::find()
            ->select('snils_or_id')
            ->andWhere(['cg_id'=>$cgId])
            ->andWhere(['<>', 'status', CompetitiveList::STATUS_NO_SUCCESS])
            ->orderBy(['sum_ball'=> SORT_DESC])
            ->limit($competitiveGroup->kcp)
            ->column();
        return in_array($snilsOrId, $applications);
    }

    private function setStatusDeficiency(CompetitiveGroupOnes $competitiveGroupOnes) {
        $amountOfAppWithNoSuccessStatus = CompetitiveList::find()
            ->andWhere(['<>','status', CompetitiveList::STATUS_NO_SUCCESS])
            ->andWhere(['cg_id'=> $competitiveGroupOnes->id])
            ->count();
        if($competitiveGroupOnes->kcp > $amountOfAppWithNoSuccessStatus) {
            $competitiveGroupOnes->status = CompetitiveGroupOnes::STATUS_DEFICIENCY;
            if(!$competitiveGroupOnes->save()) {
                print_r($competitiveGroupOnes->firstErrors);
            }
        }
    }

    private function setStatusHandled(CompetitiveGroupOnes $competitiveGroupOnes) {
        $amountSuccessStatus = CompetitiveList::find()
            ->andWhere(['status'=> CompetitiveList::STATUS_SUCCESS])
            ->andWhere(['cg_id'=> $competitiveGroupOnes->id])
            ->count();
        if($competitiveGroupOnes->kcp == $amountSuccessStatus) {
            $competitiveGroupOnes->status = CompetitiveGroupOnes::STATUS_HANDLED;
            if(!$competitiveGroupOnes->save()) {
                print_r($competitiveGroupOnes->firstErrors);
            }
        }
    }
}