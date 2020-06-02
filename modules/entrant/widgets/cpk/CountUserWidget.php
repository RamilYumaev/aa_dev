<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\readRepositories\ProfileStatementReadRepository;
use yii\base\Widget;

class CountUserWidget extends Widget
{
    public $view = "count-user";
    public $status;
    public $jobEntrant;

    public function run()
    {

        $query = (new ProfileStatementReadRepository($this->jobEntrant))->readData();
        $count = $query->count();

        return $this->render($this->view, ['count'=> $count]);
    }

}
