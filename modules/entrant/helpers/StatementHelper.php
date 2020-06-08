<?php


namespace modules\entrant\helpers;


use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementCgReadRepository;
use modules\entrant\readRepositories\StatementIAReadRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\helpers\ArrayHelper;

class StatementHelper
{
    const STATUS_DRAFT = 0;
    const STATUS_WALT  = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;
    const STATUS_RECALL = 4;
    const STATUS_WALT_SPECIAL = 5;

    public static function statusList() {
        return[
            self::STATUS_DRAFT =>"Новый",
            self::STATUS_WALT=> "Ожидание",
            self::STATUS_WALT_SPECIAL=> "Ожидание",
            self::STATUS_ACCEPTED =>"Принято",
            self::STATUS_NO_ACCEPTED =>"Не принято",
            self::STATUS_RECALL=> "Отозван"];
    }

    public static function statusListJobEntrant() {
        return[
            self::STATUS_WALT=> "Новые",
            self::STATUS_WALT_SPECIAL=> "Новые",
            self::STATUS_ACCEPTED =>"Принятые",
            self::STATUS_NO_ACCEPTED =>"Непринятые",
            self::STATUS_RECALL=> "Отозванные"];
    }

    public static function statusName($key) {
        return ArrayHelper::getValue(self::statusList(),$key);
    }

    public static function statusJobName($key) {
        return ArrayHelper::getValue(self::statusListJobEntrant(),$key);
    }


    public static function colorList() {
        return [
            self::STATUS_DRAFT =>"default",
            self::STATUS_WALT=> "warning",
            self::STATUS_WALT_SPECIAL=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_RECALL=> "error"];
    }

    public static function colorName($key) {
        return ArrayHelper::getValue(self::colorList(),$key);
    }
    public static function entrantJob() {
        return \Yii::$app->user->identity->jobEntrant();
    }

    public static function columnStatement($column, $value) {
        $query = (new StatementReadRepository(self::entrantJob()))->readData()
            ->select('statement.'.$column)->groupBy('statement.'.$column);
        return ArrayHelper::map($query->all(), $column, $value);
    }

    public static function columnStatementIa($column, $value) {
        $query =  (new StatementIAReadRepository(self::entrantJob()))
            ->readData()
            ->select('statement_individual_achievements.'.$column)
            ->groupBy('statement_individual_achievements.'.$column);

        return ArrayHelper::map($query->all(), $column, $value);
    }

    public static function columnStatementConsent($column, $value) {
        return ArrayHelper::map(Statement::find()->alias('statement')->statusNoDraft("statement.")
            ->innerJoin(StatementCg::tableName() . ' cg', 'cg.statement_id = statement.id')
            ->innerJoin(StatementConsentCg::tableName() . ' consent', 'consent.statement_cg_id = cg.id')
            ->select($column)->groupBy($column)->all(), $column, $value);
    }

    public static function columnStatementCg($column, $value) {
      $query = (new StatementCgReadRepository(self::entrantJob()))
            ->readData()
            ->select($column)
            ->groupBy($column)->all();
        return ArrayHelper::map($query, $column, $value);
    }

}