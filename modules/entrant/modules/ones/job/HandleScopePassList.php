<?php
namespace modules\entrant\modules\ones\job;

use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use yii\base\BaseObject;
use yii\queue\Queue;

class HandleScopePassList extends BaseObject implements \yii\queue\JobInterface
{

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     * @throws \yii\db\Exception
     * @throws \Exception
     */

    public function execute($queue)
    {
        $allIds = CompetitiveGroupOnes::find()->select('id')->column();
        foreach ($allIds as $item) {
            /** @var CompetitiveList $minimal */
            $minimal = CompetitiveList::find()
                ->andWhere(['cg_id' => $item, 'status' => CompetitiveList::STATUS_SUCCESS])
                ->orderBy(['sum_ball' => SORT_ASC])
                ->one();

            $list = CompetitiveList::find()
                ->andWhere(['cg_id' => $item, 'priority'=> $minimal->priority, 'status' => CompetitiveList::STATUS_NO_SUCCESS, 'sum_ball' => $minimal->sum_ball])
                ->all();
            /** @var CompetitiveList $item1 */
            $countChanged = 0;
            foreach ($list as $item1) {
                if (CompetitiveList::find()->andWhere(['and', ['snils_or_id' => $item1->snils_or_id, 'status' => CompetitiveList::STATUS_SUCCESS], ['not', ['id' => $item1->id]]])->exists()) {
                    continue;
                }
                $item1->status = $item1::STATUS_SEMI_PASS;
                $item1->save();
                $countChanged++;
            }
            if($countChanged) {
                $minimal->status = $minimal::STATUS_SEMI_PASS;
                $minimal->save();
            }
        }

    }
}