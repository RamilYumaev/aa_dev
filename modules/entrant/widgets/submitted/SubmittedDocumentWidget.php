<?php
namespace modules\entrant\widgets\submitted;
use modules\entrant\models\SubmittedDocuments;
use yii\base\Widget;

class SubmittedDocumentWidget extends Widget
{

    public $view = "index";
    public function run()
    {
        return $this->render($this->view, [
            'submitted' => SubmittedDocuments::findOne(['user_id' => \Yii::$app->user->identity->getId()]),
        ]);
    }

}
