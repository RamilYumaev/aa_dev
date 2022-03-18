<?php
namespace modules\entrant\widgets\discipline;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\Anketa;
use yii\base\Widget;

class UserDisciplineSpoWidget extends Widget
{
    public $userId;
    /* @var  $anketa  Anketa */
    public $anketa;

    public function run()
    {
        return $this->render('index-spo', [
            'exams' =>  DictCompetitiveGroupHelper::groupByExamsSpo($this->userId), 'userId' => $this->userId,
        ]);
    }
}
