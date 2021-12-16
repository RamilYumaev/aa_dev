<?php
namespace modules\transfer\widgets\info;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\models\JobEntrant;
use modules\transfer\models\PassExam;
use modules\transfer\models\StatementTransfer;
use modules\transfer\readRepositories\StatementTransferReadRepository;
use Yii;
use yii\base\Widget;

class ExamSuccessCountWidget extends Widget
{
    public $view = "index";
    public $status = PassExam::SUCCESS;
    public $icon;
    public $exam;
    public $str;
    public $link;
    public $colorBox;

    public function run()
    {
        $query = (new StatementTransferReadRepository($this->getJobEntrant()))->readDataExamPass($this->status);
        $count = $query->andWhere(['finance'=>DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT, 'success_exam'=> $this->exam])->count();
        return $this->render($this->view, ['count'=> $count, 'icon'=>$this->icon, 'str' => $this->str, 'colorBox' => $this->colorBox, 'link' => $this->link,
            'status'=> $this->status]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }
}
