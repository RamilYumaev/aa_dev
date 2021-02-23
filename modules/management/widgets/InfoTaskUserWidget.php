<?php
namespace modules\management\widgets;

use modules\management\models\Task;
use yii\base\Widget;

class InfoTaskUserWidget extends Widget
{
    public $view = "info-task";
    public $colorBox;
    public $icon;
    public $status;
    public $link;

    public function run()
    {
        $query = Task::find();
        $query->status($this->status)->userResponsible(\Yii::$app->user->identity->getId());
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => (new Task)->getStatusList()[$this->status]['name'],
            'link'=> $this->link]);
    }

}
