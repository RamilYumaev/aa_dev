<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use modules\entrant\readRepositories\StatementExamReadRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\entrant\searches\StatementExamSearch;
use yii\base\Widget;

class InfoUserExamCozWidget extends Widget
{
    public $view = "info-coz";
    public $colorBox;
    public $entrant;
    public $icon;
    public $exam;
    public $str;
    public $link;

    public function run()
    {
        $query = (new StatementExamReadRepository($this->entrant, $this->exam))->readData();
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
