<?php
namespace modules\transfer\widgets\info;


use modules\dictionary\models\JobEntrant;
use modules\transfer\readRepositories\TransferReadRepository;
use Yii;
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
        $query = (new TransferReadRepository($this->type, $this->getJobEntrant()))->readData();
        return $this->render($this->view, ['count'=> $query->count(),
            'colorBox' => $this->colorBox,
            'icon'=> $this->icon,
            'link'=> $this->link,
            'str' => $this->str,
            ]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

}
