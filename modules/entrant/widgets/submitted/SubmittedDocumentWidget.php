<?php
namespace modules\entrant\widgets\submitted;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\SubmittedDocuments;
use yii\base\Widget;

class SubmittedDocumentWidget extends Widget
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
        $array = ['submitted' => SubmittedDocuments::findOne(['user_id' => $this->getIdUser()]), 'userId' =>  $this->getIdUser()];
        if ($this->view !== "index") {
          return  array_merge($array, ['userCg' => $this->listCgUser()]);
        }
        return $array;
    }


}
