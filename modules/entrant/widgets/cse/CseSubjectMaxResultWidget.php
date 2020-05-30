<?php
namespace modules\entrant\widgets\cse;

use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\models\CseSubjectResult;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CseSubjectMaxResultWidget extends Widget
{
    public $userId;
    public $view = "max";
    public function run()
    {
        return $this->render($this->view, [
            'maxSubjectResult' => CseSubjectHelper::maxMarkSubject( $this->userId),
        ]);
    }



}
