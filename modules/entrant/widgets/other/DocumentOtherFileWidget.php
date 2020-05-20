<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class DocumentOtherFileWidget extends Widget
{

    public $userId;
    public function run()
    {
        $model = OtherDocument::find()->where(['user_id' => $this->userId])->all();
        return $this->render('file', [
            'others' => $model
        ]);
    }

}
