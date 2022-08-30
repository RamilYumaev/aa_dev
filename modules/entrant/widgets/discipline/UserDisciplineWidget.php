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

    public $foreignStatus = false;

    public function run()
    {
        if($this->anketa->onlyCse()) {
            return $this->render('index', [
                'userDisciplines' => UserDiscipline::find()->cseOrCt()->user($this->userId)->all(), 'userId' => $this->userId,
            ]);
        }
        return $this->render( !$this->foreignStatus ? 'index-vi' : 'index-ums', [
            'exams' => !$this->foreignStatus ?  DictCompetitiveGroupHelper::groupByExams($this->userId, $this->anketa->onlySpo())
            : DictCompetitiveGroupHelper::groupByExamsForeign($this->userId)
            , 'userId' => $this->userId,
        ]);
    }
}
