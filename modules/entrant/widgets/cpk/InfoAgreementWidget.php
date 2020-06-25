<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\readRepositories\AgreementReadRepository;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use modules\entrant\readRepositories\StatementIAReadRepository;
use modules\entrant\readRepositories\StatementReadConsentRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\base\Widget;

class InfoAgreementWidget extends Widget
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
        $query = (new AgreementReadRepository())->readData();
        $query->status($this->status);
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
