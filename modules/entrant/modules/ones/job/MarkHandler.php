<?php


namespace modules\entrant\modules\ones\job;


use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class MarkHandler extends BaseObject implements \yii\queue\JobInterface
{
    public $counter;
    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        $this->counter++;
        $priorities = CompetitiveList::find()
            ->select('priority')
            ->andWhere(['status'=> CompetitiveList::STATUS_NEW])
            ->groupBy('priority')
            ->orderBy(['priority'=>SORT_ASC])
            ->column();

        foreach ($priorities as $priority) {
            $allUnhandledApplications = CompetitiveList::find()
                ->andWhere(['priority'=> $priority])
                ->andWhere(['status'=> CompetitiveList::STATUS_NEW])
                ->orderBy(['number'=> SORT_ASC])
                ->all();
            /**
             * @var $allUnhandledApplication CompetitiveList
             */
            foreach ($allUnhandledApplications as $allUnhandledApplication) {
                if($this->contest($allUnhandledApplication->cg_id, $allUnhandledApplication->id)) {
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
            }
        }
        if(CompetitiveList::find()->andWhere(['status'=> CompetitiveList::STATUS_NEW])->exists()) {
            if($this->counter <= max($priorities)) {
                Yii::$app->queue->push(new MarkHandler(['counter' => $this->counter]));
            } else {
                Yii::$app->queue->push(new FinishedHandler());
            }
        }

    }
    private function contest(int $cgId, int $applicationId){

        $competitiveGroup = CompetitiveGroupOnes::findOne($cgId);
        $applications = CompetitiveList::find()
            ->select('id')
            ->andWhere(['cg_id'=>$cgId])
            ->andWhere(['<>', 'status', CompetitiveList::STATUS_NO_SUCCESS])
            ->orderBy(['number'=> SORT_ASC])
            ->limit($competitiveGroup->kcp)
            ->column();
        return in_array($applicationId, $applications);
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