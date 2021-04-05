<?php
namespace modules\entrant\widgets\discipline;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\UserDiscipline;
use yii\base\Widget;

class UserDisciplineWidget extends Widget
{
    public $userId;
    /* @var  $anketa  Anketa */
    public $anketa;

    public function run()
    {
        if($this->anketa->onlyCse()) {
            return $this->render('index', [
                'userDisciplines' => UserDiscipline::find()->cseOrCt()->user($this->userId)->all(), 'userId' => $this->userId,
            ]);
        }
        return $this->render('index-vi', [
            'exams' =>  DictCompetitiveGroupHelper::groupByExams($this->userId), 'userId' => $this->userId,
        ]);
    }
}
