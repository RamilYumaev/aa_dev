<?php
namespace modules\entrant\widgets\submitted;
use modules\entrant\models\SubmittedDocuments;
use yii\base\Widget;

class SubmittedDocumentWidget extends Widget
{
    public function run()
    {
        return $this->render('index', [
            'submitted' => SubmittedDocuments::findOne(['user_id' => \Yii::$app->user->identity->getId()]),
        ]);
    }

}
