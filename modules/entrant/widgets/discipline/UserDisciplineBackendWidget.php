<?php
namespace modules\entrant\widgets\discipline;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\UserDiscipline;
use yii\base\Widget;

class UserDisciplineBackendWidget extends Widget
{
    public $userId;

    public function run()
    {
        return $this->render('index-maxi', [
            'userDisciplines' => UserDiscipline::find()->user($this->userId)->all(), 'userId' => $this->userId]);
    }
}
