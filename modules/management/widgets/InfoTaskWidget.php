<?php
namespace modules\management\widgets;

use modules\management\models\Task;
use yii\base\Widget;

class InfoTaskWidget extends Widget
{
    public $view = "info-task";
    public $colorBox;
    public $icon;
    public $status;
    public $link;

    public function run()
    {
        $query = Task::find();
        $query->status($this->status);
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => (new Task)->getStatusList()[$this->status]['name'],
            'link'=> $this->link]);
    }

}
