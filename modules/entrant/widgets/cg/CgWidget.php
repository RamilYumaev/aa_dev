<?php
namespace modules\entrant\widgets\cg;

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\base\Widget;

class CgWidget extends Widget
{
    public $view = "index";

    public function run()
    {
        return $this->render($this->view, $this->config());
    }

    private function listCgUser() {
        return DictCompetitiveGroupHelper::groupByFacultySpecialityAllUser($this->getIdUser());
    }

    private function getIdUser() {
        return \Yii::$app->user->identity->getId();
    }

    private function config() {
        $array = ['userId' =>  $this->getIdUser(), 'userCg' => $this->listCgUser()];
        return $array;
    }
}
