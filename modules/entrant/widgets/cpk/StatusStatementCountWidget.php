<?php
namespace modules\entrant\widgets\cpk;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementIAReadRepository;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class StatusStatementCountWidget extends Widget
{
    public $view = "index";
    public $status;
    public $jobEntrant;
    public $colorBox;

    public function run()
    {
        $query = (new StatementIAReadRepository($this->jobEntrant))->readData();
        $query->andWhere(['statement.status'=>  $this->status]);
        $count = $query->count();
        return $this->render($this->view, ['count'=> $count, 'colorBox' => $this->colorBox, 'status'=> $this->status]);
    }

}
