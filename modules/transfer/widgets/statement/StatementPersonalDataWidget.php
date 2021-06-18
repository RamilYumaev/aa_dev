<?php
namespace modules\transfer\widgets\statement;


use modules\transfer\models\StatementConsentPersonalData;
use yii\base\Widget;
use Yii;

class StatementPersonalDataWidget extends Widget
{
    public $userId;
    public $view = 'index-pd';


    public function init()
    {
       if(!$this->findModel()) {
           StatementConsentPersonalData::create($this->userId)->save();
       }
    }

    public function run()
    {
        return $this->render($this->view, [
            'statement'=> $this->findModel(),
        ]);
    }

    public function findModel()
    {
        return StatementConsentPersonalData::findOne(['user_id' => $this->userId]);
    }
}
