<?php
namespace modules\transfer\widgets\info;

use modules\entrant\readRepositories\ContractReadRepository;
use modules\transfer\models\StatementAgreementContractTransferCg;
use yii\base\Widget;

class InfoContractWidget extends Widget
{
    public $view = "index";
    public $colorBox;
    public $entrant = null;
    public $icon;
    public $status;
    public $str;
    public $link;

    public function run()
    {
        $query = StatementAgreementContractTransferCg::find()->andWhere(["status_id"=> $this->status]);

        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
