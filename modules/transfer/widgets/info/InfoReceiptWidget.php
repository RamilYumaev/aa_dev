<?php
namespace modules\transfer\widgets\info;

use modules\entrant\readRepositories\ReceiptReadRepository;
use modules\transfer\models\ReceiptContractTransfer;
use yii\base\Widget;

class InfoReceiptWidget extends Widget
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
        $query = ReceiptContractTransfer::find();
        $query->andWhere(['status_id'=>$this->status]);
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
