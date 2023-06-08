<?php

namespace modules\entrant\forms;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;

class AgreementClarifyCgForm extends Agreement
{

    public function rules()
    {
        return [
            ['competitive_list', 'safe'],
            ['competitive_list', 'required']];
    }

    public function getEntrantCg()
    {
        $cgs = StatementCg::find()
            ->statementStatus($this->user_id, NULL)
            ->andWhere([Statement::tableName() . ".`status`" => StatementHelper::STATUS_ACCEPTED,
                // Statement::tableName().".`finance`" => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET
            ])
            ->all();
        $array = [];
        /* @var $cg StatementCg */
        foreach ($cgs as $cg) {
            $array[$cg->cg_id] = $cg->cg->fullNameB;
        }
        return $array;
    }

}