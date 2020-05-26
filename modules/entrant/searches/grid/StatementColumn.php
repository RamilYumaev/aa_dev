<?php

namespace modules\entrant\searches\grid;

use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use yii\grid\DataColumn;
use yii\helpers\Html;


class StatementColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return $this->getStatementCgConsent($model) ."". $this->getStatementIA($model);
    }

    private function getStatementIA(Statement $statement): string
    {
        $statementIa = StatementIndividualAchievements::find()->statusNoDraft()->eduLevel($statement->edu_level)->user($statement->user_id)->exists();
        return $statementIa ? Html::tag('span', Html::encode("ЗИД"), ['class' => 'label label-warning']) :$this->grid->emptyCell;
    }

    private function getStatementCgConsent(Statement $statement): string
    {
        $statementConsent = $statement->statementCgConsent();
        return $statementConsent ? Html::tag('span', Html::encode("ЗОС"), ['class' => 'label label-primary']) :$this->grid->emptyCell;
    }
}