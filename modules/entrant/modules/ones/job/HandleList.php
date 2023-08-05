<?php
namespace modules\entrant\modules\ones\job;

use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use yii\base\BaseObject;
use yii\queue\Queue;

class HandleList extends BaseObject implements \yii\queue\JobInterface
{

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     * @throws \yii\db\Exception
     * @throws \Exception
     */

    public function execute($queue)
    {
        $allPriority = CompetitiveList::find()->select('priority')->groupBy('priority')->column();
        foreach ($allPriority as $item) {
            $list = CompetitiveList::find()
                ->andWhere(['priority' => $item, 'status' => CompetitiveList::STATUS_NEW])
                ->orderBy(['sum_ball' => SORT_DESC])
                ->all();
            /** @var CompetitiveList $item1 */
            foreach ($list as $item1) {
                $count = CompetitiveList::find()->with('competitiveGroup')
                    ->andWhere(['cg_id' => $item1->cg_id, 'status' => $item1::STATUS_SUCCESS])
                    ->count();
                if($count == $item1->competitiveGroup->kcp) {
                    CompetitiveGroupOnes::updateAll(['status' => CompetitiveGroupOnes::STATUS_HANDLED],  ['id'=> $item1->cg_id]);
                    CompetitiveList::updateAll(['status' => $item1::STATUS_NO_SUCCESS], ['status' => CompetitiveList::STATUS_NEW,  'cg_id' => $item1->cg_id]);
                } else {
                     $item1->status = $item1::STATUS_SUCCESS;
                     if($item1->save()) {
                         CompetitiveList::updateAll(['status' => $item1::STATUS_NO_SUCCESS], ['and', ['snils_or_id'=> $item1->snils_or_id], ['not', ['id' => $item1->id]]]);
                     }
                }
            }
        }

    }
}