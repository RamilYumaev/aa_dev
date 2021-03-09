<?php
namespace modules\management\widgets;

use modules\management\models\Task;
use yii\base\Widget;

class InfoTaskFullWidget extends Widget
{
    public $view = "info-full-task";
    public $colorBox;
    public $icon;
    public $str;
    public $link;
    public $overdue = true;
    public $admin = false;

    public function run()
    {
        $query = Task::find();
        if(!$this->admin) {
            $query->userResponsible(\Yii::$app->user->identity->getId());
        }
        $where  = [$this->overdue ? '<' : '>','date_end', date("Y-m-d H:i:s")];
        $query->andWhere($where)->status([Task::STATUS_NEW, Task::STATUS_REWORK, Task::STATUS_WORK]);
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->overdue ? "Просроченные" : "Актуальные",
            'link'=> $this->link, 'parameter' => $this->overdue ? 'yes' : 'no']);
    }

}
