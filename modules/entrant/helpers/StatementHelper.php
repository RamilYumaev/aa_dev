<?php


namespace modules\entrant\helpers;


use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementCgReadRepository;
use modules\entrant\readRepositories\StatementExamReadRepository;
use modules\entrant\readRepositories\StatementIAReadRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\entrant\searches\StatementAgreementContractSearch;
use yii\helpers\ArrayHelper;

class StatementHelper
{
    const STATUS_DRAFT = 0;
    const STATUS_WALT  = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;
    const STATUS_RECALL = 4;
    const STATUS_WALT_SPECIAL = 5;
    const STATUS_VIEW = 6;
    const STATUS_NO_REAL = 7;
    const STATUS_SUCCESS = 8;


    public static function statusList() {
        return[
            self::STATUS_DRAFT =>"Новое",
            self::STATUS_WALT=> "Обрабатывается",
            self::STATUS_WALT_SPECIAL=> "Обрабатывается",
            self::STATUS_ACCEPTED =>"Принято",
            self::STATUS_NO_ACCEPTED =>"Не принято",
            self::STATUS_RECALL=> "Отозвано",
            self::STATUS_VIEW => "Взято в работу"];
    }

    public static function statusContractList() {
        return[
            self::STATUS_ACCEPTED =>"Проверен",
            self::STATUS_NO_ACCEPTED =>"Отклонен",
            self::STATUS_WALT=> "Ообрабатывается",
            self::STATUS_VIEW => "Взято в работу",
            self::STATUS_NO_REAL => "Недействительный",
            self::STATUS_SUCCESS => "Подписан",
            ];
    }


    public static function statusListJobEntrant() {
        return[
            self::STATUS_WALT=> "Новое",
            self::STATUS_WALT_SPECIAL=> "Новое",
            self::STATUS_ACCEPTED =>"Принято",
            self::STATUS_NO_ACCEPTED =>"Не принято",
            self::STATUS_RECALL=> "Отозвано",
            self::STATUS_VIEW => "Взято в работу"];
    }

    public static function statusListJobEntrants() {
        return[
            self::STATUS_WALT=> "Новые",
            self::STATUS_WALT_SPECIAL=> "Новые",
            self::STATUS_ACCEPTED =>"Принятые",
            self::STATUS_NO_ACCEPTED =>"Непринятые",
            self::STATUS_RECALL=> "Отозванные",
            self::STATUS_VIEW => "Взято в работу"];
    }

    public static function statusName($key) {
        return ArrayHelper::getValue(self::statusList(),$key);
    }

    public static function statusJobName($key) {
        return ArrayHelper::getValue(self::statusListJobEntrant(),$key);
    }

    public static function statusContractName($key) {
        return ArrayHelper::getValue(self::statusContractList(),$key);
    }


    public static function colorList() {
        return [
            self::STATUS_DRAFT =>"default",
            self::STATUS_WALT=> "warning",
            self::STATUS_WALT_SPECIAL=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_RECALL=> "danger",
            self::STATUS_VIEW => "info"];
    }

    public static function colorName($key) {
        return ArrayHelper::getValue(self::colorList(),$key);
    }
    public static function entrantJob() {
        return \Yii::$app->user->identity->jobEntrant();
    }

    public static function columnStatement($column, $joinW, $value) {
        $query = (new StatementReadRepository(self::entrantJob()))->readData()->joinWith($joinW)
            ->select([$value,'statement.'.$column])->indexBy('statement.'.$column);
        return  $query->column();
    }

    public static function columnExamStatement($column, $joinW, $value, $exam) {
        $query = (new StatementExamReadRepository(self::entrantJob(), $exam))->readData()->joinWith($joinW)
            ->select([$value,'statement.'.$column])->indexBy('statement.'.$column);
        return  $query->column();
    }

    public static function columnStatementIa($column, $joinW, $value) {
        $query =  (new StatementIAReadRepository(self::entrantJob()))
            ->readData()->joinWith($joinW)
            ->select([$value,'statement_individual_achievements.'.$column])
            ->indexBy('statement_individual_achievements.'.$column);

        return $query->column();
    }

    public static function columnStatementConsent($column,  $joinW, $value) {
        return (new StatementReadRepository(self::entrantJob()))
            ->readData(true)
            ->innerJoin(StatementCg::tableName() . ' cg', 'cg.statement_id = statement.id')
            ->innerJoin(StatementConsentCg::tableName() . ' consent', 'consent.statement_cg_id = cg.id')
            ->andWhere(['statement.status'=> self::STATUS_ACCEPTED])->joinWith( $joinW)
            ->select([$value,'statement.'.$column])->indexBy('statement.'.$column)->column();
    }

    public static function columnStatementConsentCg($column, $value) {
        $array = [];
        $query = (new StatementCgReadRepository(self::entrantJob()))
            ->readData()
            ->innerJoin(StatementConsentCg::tableName() . ' consent', 'consent.statement_cg_id = statement_cg.id')
            ->andWhere(['statement.status'=> self::STATUS_ACCEPTED])
            ->select($column)->indexBy($column)->all();
        foreach ($query as $stCg) {
            /* @var  $stCg StatementCg  */
            $array[$stCg->{$column}] = $stCg->cg->{$value};
        }
        return $array;

    }


    public static function columnStatementAgreement($column, $joinW, $value) {
        return Statement::find()->alias('statement')->statusNoDraft("statement.")
            ->innerJoin(StatementCg::tableName() . ' cg', 'cg.statement_id = statement.id')
            ->innerJoin(StatementAgreementContractCg::tableName() . ' consent', 'consent.statement_cg = cg.id')
            ->joinWith( $joinW)
            ->select([$value,'statement.'.$column])->indexBy('statement.'.$column)->column();
    }

    public static function columnStatementAgreementCg($column, $value) {
        $array = [];
        $query = StatementCg::find()->alias('cg')
            ->innerJoin(StatementAgreementContractCg::tableName() . ' contract', 'contract.statement_cg = cg.id')
            ->select($column)->indexBy($column)->all();
        foreach ($query as $stCg) {
            /* @var  $stCg StatementCg  */
            $array[$stCg->{$column}] = $stCg->cg->{$value};
        }
        return $array;

    }

    public static function columnStatementCg($column, $value) {
          $query = (new StatementCgReadRepository(self::entrantJob()))
                ->readData()
                ->select($column)
                ->groupBy($column)->all();
            return ArrayHelper::map($query, $column, $value);
    }


    public static function statementSuccess($userId, $eduLevel) {
        return Statement::find()->eduLevel($eduLevel)->user($userId)->status(self::STATUS_ACCEPTED)->exists();
    }

    public static function columnRejectionRecord($column,  $joinW, $value) {
        return StatementRejectionRecord::find()->joinWith( $joinW)
            ->select([$value, $column])->indexBy($column)->column();
    }

    public static function columnRejectionRecordCg($column, $value) {
        $array = [];
        $query =  StatementRejectionRecord::find()->select($column)->indexBy($column)->all();
        foreach ($query as $stCg) {
            /* @var  $stCg StatementCg  */
            $array[$stCg->{$column}] = $stCg->cg->{$value};
        }
        return $array;

    }

}