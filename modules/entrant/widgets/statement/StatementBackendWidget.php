<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\Statement;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementBackendWidget extends Widget
{
    public $statement;

    public $view = 'index-backend-view';
    public function run()
    {
        return $this->render($this->view, [
            'statement'=> $this->statement,
        ]);
    }
}
