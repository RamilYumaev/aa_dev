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
    public $key = "responsible_user_id";
    public $admin = false;

    public function run()
    {
        $query = Task::find();
        $query->status($this->status);
        if(!$this->admin) {
            $query->user(\Yii::$app->user->identity->getId(), $this->key);
        }
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => (new Task)->getStatusList()[$this->status]['name'],
            'status' => $this->status,
            'link'=> $this->link]);
    }

}
