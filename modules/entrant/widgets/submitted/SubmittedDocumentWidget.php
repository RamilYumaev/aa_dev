<?php

namespace modules\entrant\widgets\submitted;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class SubmittedDocumentWidget extends Widget
{

    public $userId;
    private $view = "index";

    public function run()
    {
        return $this->render($this->view,
            ['submitted' => SubmittedDocuments::findOne(['user_id' => $this->userId]),
            'userId' =>  $this->userId]);
    }

}
