<?php
namespace modules\entrant\widgets\discipline;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Anketa;
use modules\entrant\models\UserDiscipline;
use yii\base\Widget;

class UserDisciplineSpoCgWidget extends Widget
{
    public $userId;
    public $spoDiscipline;

    public function run()
    {
        $cgs = DictCompetitiveGroup::find()->userCgAndExamSpo($this->userId, $this->spoDiscipline)->all();
        return $this->render('index-cg', [
            'cgs' =>  $cgs, 'userId' => $this->userId, 'disciplineSpo' => $this->spoDiscipline
        ]);
    }
}
