<?php
namespace modules\transfer\widgets\info;

use modules\transfer\models\StatementTransfer;
use yii\base\Widget;

class StatusStatementCountWidget extends Widget
{
    public $view = "index";
    public $status;
    public $icon;
    public $str;
    public $link;

    public $colorBox;

    public function run()
    {
        $query = StatementTransfer::find()->andWhere(['status'=> $this->status]);
        $count = $query->count();
        return $this->render($this->view, ['count'=> $count, 'icon'=>$this->icon, 'str' => $this->str, 'colorBox' => $this->colorBox, 'link' => $this->link,
            'status'=> $this->status]);
    }

}
