<?php
namespace modules\entrant\widgets\other;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class PhotoOtherWidget extends Widget
{
    public $view;
    public $userId;

    public function run()
    {
        $model = OtherDocument::find()->where(['user_id' =>  $this->userId, 'type'=> DictIncomingDocumentTypeHelper::ID_PHOTO])->all();
        return $this->render($this->view, [
            'others' => $model,
        ]);
    }




}
