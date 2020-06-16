<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementIndexWidget extends Widget
{
    public $userId;
    public $view = 'statement-index';

    public function run()
    {
        $query = Statement::find()->user($this->userId);
        $model = clone $query;

        $isAccepted = $query->status(StatementHelper::STATUS_ACCEPTED)->exists();
        return $this->render($this->view, [
            'statements'=> $model->statusNoDraft()->all(),
             'isAccepted' => $isAccepted,
             'isContract' => $this->isContract()
        ]);
    }

    private function  isContract() {
        foreach (Statement::find()->user($this->userId)->all() as $st)
            {   /* @var $st Statement*/
                if ($st->statementContractCg()) {
                    $bool = true;
                    break;
                }
            }
            return $bool ?? false;
        }
}
