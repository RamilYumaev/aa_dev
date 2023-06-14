<?php
namespace modules\entrant\widgets\other;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class MedicineOtherWidget extends Widget
{
    public $view = "medicine";
    public $userId;

    public function run()
    {
        $model = OtherDocument::find()->where(['user_id' =>  $this->userId, 'type' => DictIncomingDocumentTypeHelper::ID_MEDICINE])->one();
        return $this->render($this->view, [
            'other' => $model,
        ]);
    }




}
