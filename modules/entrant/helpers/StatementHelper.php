<?php


namespace modules\entrant\helpers;


use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use yii\helpers\ArrayHelper;

class StatementHelper
{
    const STATUS_DRAFT = 0;
    const STATUS_WALT  = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;
    const STATUS_RECALL = 4;

    public static function statusList() {
        return[
            self::STATUS_DRAFT =>"Новый",
            self::STATUS_WALT=> "Ожидание",
            self::STATUS_ACCEPTED =>"Принято",
            self::STATUS_NO_ACCEPTED =>"Не принято",
            self::STATUS_RECALL=> "Отозван"];
    }

    public static function statusName($key) {
        return self::statusList()[$key];
    }

    public static function colorList() {
        return [
            self::STATUS_DRAFT =>"default",
            self::STATUS_WALT=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_RECALL=> "error"];
    }

    public static function colorName($key) {
        return self::colorList()[$key];
    }

    public static function columnStatement($column, $value) {
        return ArrayHelper::map(Statement::find()->select($column)->groupBy($column)->all(), $column, $value);
    }

    public static function columnStatementIa($column, $value) {
        return ArrayHelper::map(StatementIndividualAchievements::find()->select($column)->groupBy($column)->all(), $column, $value);
    }

    public static function columnStatementConsent($column, $value) {
        return ArrayHelper::map(Statement::find()->alias('statement')
            ->innerJoin(StatementCg::tableName() . ' cg', 'cg.statement_id = statement.id')
            ->innerJoin(StatementConsentCg::tableName() . ' consent', 'consent.statement_cg_id = cg.id')
            ->select($column)->groupBy($column)->all(), $column, $value);
    }

}