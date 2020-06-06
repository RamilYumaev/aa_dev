<?php
namespace modules\entrant\widgets\statement;


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
        $model = Statement::find()->user($this->userId)->statusNoDraft()
            ->all();
        return $this->render($this->view, [
            'statements'=> $model,
        ]);
    }
}
