<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use modules\entrant\readRepositories\StatementReadConsentRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\base\Widget;

class InfoFokZosWidget extends Widget
{
    public $view = "info-coz";
    public $colorBox;
    public $entrant;
    public $icon;
    public $status;
    public $str;
    public $link;

    public function run()
    {
        $query = (new StatementReadConsentRepository($this->entrant))->readData();
        $query->status($this->status, 'consent.');
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
