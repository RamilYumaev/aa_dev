<?php

namespace modules\entrant\widgets\agreement;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use yii\base\Widget;

class AgreementWidget extends Widget
{
    public $userId;
    public $view;

    public function run()
    {
        $model = Agreement::findOne(['user_id' => $this->userId]);
        $cgs = StatementCg::find()
            ->statementStatus($model->user_id, NULL)
            ->andWhere([Statement::tableName().".`status`" => StatementHelper::STATUS_ACCEPTED,
               // Statement::tableName().".`finance`" => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET
            ])
            ->all();
        return $this->render($this->view, [
            'model' => $model,
            'cgs' => $cgs,
        ]);
    }
}
