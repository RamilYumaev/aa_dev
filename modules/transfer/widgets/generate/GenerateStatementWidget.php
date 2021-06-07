<?php
namespace modules\transfer\widgets\generate;


use modules\transfer\models\StatementTransfer;
use yii\base\Widget;
use Yii;

class GenerateStatementWidget extends Widget{
    public $type;
    public $userId;


    public function init()
    {
        if(!$this->statement()) {
            StatementTransfer::create($this->userId, $this->type)->save();
        }

    }

    public function run()
    {
        return $this->render('statement', ['statement'=> $this->statement()]);
    }

    protected function statement() {
        return StatementTransfer::findOne(['user_id' => $this->userId]);
    }

}
