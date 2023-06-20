<?php
namespace modules\entrant\widgets\discipline;

use modules\entrant\helpers\UserCgHelper;
use modules\entrant\models\PsychoTestSpo;
use yii\base\Widget;
use Yii;

class PsychoTestSpoWidget extends Widget
{
    public $userId;
    private $isExamPsychology;
    public $view = 'psycho-test-spo';
    public function __construct($config = [])
    {
        $this->isExamPsychology = UserCgHelper::isExamPsychology($this->userId);
        parent::__construct($config);
    }

    /**
     * @throws \yii\db\StaleObjectException
     */
    public function init()
    {
        $model = $this->getModel();
        if($model && !$this->isExamPsychology) {
            $model->delete();
        }else {
            (new PsychoTestSpo(['user_id' => $this->userId]))->save();
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
