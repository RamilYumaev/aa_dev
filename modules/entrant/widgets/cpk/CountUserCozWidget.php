<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\readRepositories\ProfileStatementReadRepository;
use yii\base\Widget;

class CountUserCozWidget extends Widget
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
        $count = (new ProfileStatementReadRepository($this->entrant, $this->isID))->readData($this->type)->count();

        return $this->render($this->view, ['count'=> $count,
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'str' => $this->str,
            'link'=> $this->link]);
    }

}
