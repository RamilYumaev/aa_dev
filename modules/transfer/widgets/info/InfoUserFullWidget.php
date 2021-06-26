<?php
namespace modules\transfer\widgets\info;

use modules\management\models\Task;
use modules\transfer\models\TransferMpgu;
use yii\base\Widget;

class InfoUserFullWidget extends Widget
{
    public $view = "info-full-task";
    public $colorBox;
    public $type = 0;
    public $icon;
    public $str;
    public $link;
    public function run()
    {
        $query = TransferMpgu::find();
        if($this->type) {
            $query->andWhere(['type' => $this->type]);
        }
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'link'=> $this->link,
            'str' => $this->str,
            ]);
    }

}
