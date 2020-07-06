<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\readRepositories\ReceiptReadRepository;
use yii\base\Widget;

class InfoReceiptWidget extends Widget
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
        $query = (new ReceiptReadRepository($this->entrant))->readData();
        $query->andWhere(['receipt.status_id'=>$this->status]);
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
