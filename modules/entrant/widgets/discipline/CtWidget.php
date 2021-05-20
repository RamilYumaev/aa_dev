<?php
namespace modules\entrant\widgets\discipline;

use modules\entrant\models\UserDiscipline;
use yii\base\Widget;

class CtWidget extends Widget
{
    public $userId;
    public $view;
    public function run()
    {
        $model = UserDiscipline::find()->user($this->userId)->ctOrVi()->all();
        return $this->render($this->view, [
            'all'=> $model,
        ]);
    }
}
