<?php
namespace modules\transfer\widgets\passport;

use modules\entrant\models\PassportData;
use yii\base\Widget;

class PassportMainWidget extends Widget
{
    public $view;
    public $userId;
    public $referrer = '';

    public function run()
    {
        $model = PassportData::findOne(['user_id' => $this->userId, 'main_status'=> true]);
        return $this->render($this->view, [
            'model' => $model,
            'referrer' => $this->referrer,
        ]);
    }

}
