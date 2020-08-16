<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\readRepositories\ProfileFileReadRepository;
use yii\base\Widget;

class CountUserErrorFilesCozWidget extends Widget
{
    public $view = "count-user-coz";
    public $colorBox;
    public $entrant;
    public $icon;
    public $type;
    public $str;
    public $link;
    public $isID = false;

    public function run()
    {
        $count = (new ProfileFileReadRepository($this->entrant))->readData()->count();
        return $this->render($this->view, ['count'=> $count,
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
