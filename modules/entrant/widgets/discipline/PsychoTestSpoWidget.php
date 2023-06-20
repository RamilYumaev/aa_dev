<?php
namespace modules\entrant\widgets\discipline;

use modules\entrant\helpers\UserCgHelper;
use modules\entrant\models\PsychoTestSpo;
use yii\base\Widget;
use Yii;

class PsychoTestSpoWidget extends Widget
{
    public $userId;
    public $view = 'psycho-test-spo';
    /**
     * @throws \yii\db\StaleObjectException
     */
    public function init()
    {
        $model = $this->getModel();
        if(!$model) {
            UserCgHelper::isExamPsychology($this->userId) ? (new PsychoTestSpo(['user_id' => $this->userId]))->save() : null;
        }
    }

    public function run()
    {
        return $this->render($this->view, ['model' => $this->getModel()]);
    }

    private function getModel() {
        return PsychoTestSpo::findOne(['user_id' => $this->userId]);
    }
}
