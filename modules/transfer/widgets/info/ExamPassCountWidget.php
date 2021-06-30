<?php
namespace modules\transfer\widgets\info;

use modules\dictionary\models\JobEntrant;
use modules\transfer\models\StatementTransfer;
use modules\transfer\readRepositories\StatementTransferReadRepository;
use Yii;
use yii\base\Widget;

class ExamPassCountWidget extends Widget
{
    public $view = "index";
    public $status;
    public $icon;
    public $str;
    public $link;
    public $colorBox;

    public function run()
    {
        $query = (new StatementTransferReadRepository($this->getJobEntrant()))->readDataExamPass($this->status);
        $count = $query->count();
        return $this->render($this->view, ['count'=> $count, 'icon'=>$this->icon, 'str' => $this->str, 'colorBox' => $this->colorBox, 'link' => $this->link,
            'status'=> $this->status]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }
}
