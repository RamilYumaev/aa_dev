<?php


namespace modules\entrant\modules\ones\job;


use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;

class FinishedHandler extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        $allUnhandledApplications = CompetitiveList::find()
            ->andWhere(['status'=> CompetitiveList::STATUS_NEW])
            ->orderBy(['priority'=> SORT_DESC])
            ->all();
            /**
             * @var $allUnhandledApplication CompetitiveList
             */
            foreach ($allUnhandledApplications as $allUnhandledApplication)
            { $appSuccess =  CompetitiveList::find()->andWhere(['snils_or_id' => $allUnhandledApplication->snils_or_id,
                'status' => CompetitiveList::STATUS_NO_SUCCESS])->one();
                 if($appSuccess) {
                     CompetitiveList::updateAll(
                         ['status' => CompetitiveList::STATUS_NO_SUCCESS],
                         ['and', ['snils_or_id' => $appSuccess->snils_or_id],
                             ['<', 'priority', $appSuccess->priority],
                             ['not', ['id' => $appSuccess->id]]]);
                 }else {
                     CompetitiveList::updateAll(
                         ['status' => CompetitiveList::STATUS_NO_SUCCESS],
                         ['snils_or_id' => $allUnhandledApplication->snils_or_id]);
                 }
            }

            $cgs  = CompetitiveGroupOnes::find()->joinWith('competitiveList')->all();
            foreach ($cgs as $cg) {
                $this->setStatusDeficiency($cg);
                $this->setStatusHandled($cg);
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