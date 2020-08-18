<?php
namespace modules\entrant\widgets\statement;


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
