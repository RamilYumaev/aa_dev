<?php
namespace modules\management\widgets;

use modules\management\models\Task;
use yii\base\Widget;

class InfoTaskFullUserWidget extends Widget
{
    public $view = "info-full-task";
    public $colorBox;
    public $icon;
    public $str;
    public $link;
    public $overdue = true;

    public function run()
    {
        $query = Task::find();
        $query->userResponsible(\Yii::$app->user->identity->getId());
        $where  = [$this->overdue ? '<' : '>','date_end', date("Y-m-d")];
        $query->andWhere($where);
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->overdue ? "Просроченные" : "Актуальные",
            'link'=> $this->link]);
    }

}
