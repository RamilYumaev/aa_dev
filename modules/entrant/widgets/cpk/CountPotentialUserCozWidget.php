<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\readRepositories\ProfilePotentialReadRepository;
use yii\base\Widget;

class CountPotentialUserCozWidget extends Widget
{
    public $view = "count-user-coz";
    public $colorBox;
    public $entrant;
    public $icon;
    public $type = false;
    public $str;
    public $link;
    public $isID = false;

    public function run()
    {
        $count = (new ProfilePotentialReadRepository($this->entrant, $this->isID))->readData()->count();

        return $this->render($this->view, ['count'=> $count,
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
