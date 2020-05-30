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
        $query = Statement::find()->statusNoDraft()->select('statement.'.$column)->groupBy('statement.'.$column);
        $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=statement.user_id');
        /* @var $jobEntrant JobEntrant*/
        $jobEntrant = \Yii::$app->user->identity->jobEntrant();
        if($jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($jobEntrant->isCategoryTarget()) {
            $query->andWhere([
                'statement.special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]);
        }

        if($jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $jobEntrant->category_id]);
        }

        return ArrayHelper::map($query->all(), $column, $value);
    }

    public static function columnStatementIa($column, $value) {
        $query = StatementIndividualAchievements::find()->statusNoDraft()->select('statement_individual_achievements.'.$column)
            ->groupBy('statement_individual_achievements.'.$column);
        $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=statement_individual_achievements.user_id');
        /* @var $jobEntrant JobEntrant*/
        $jobEntrant = \Yii::$app->user->identity->jobEntrant();
        if($jobEntrant->isCategoryMPGU()) {
            $query->andWhere(['statement_individual_achievements.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement_individual_achievements.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement_individual_achievements.user.user_id');
            $query->andWhere(['anketa.university_choice'=> $jobEntrant->category_id]);
        }
        return ArrayHelper::map($query->all(), $column, $value);
    }

    public static function columnStatementConsent($column, $value) {
        return ArrayHelper::map(Statement::find()->alias('statement')->statusNoDraft("statement.")
            ->innerJoin(StatementCg::tableName() . ' cg', 'cg.statement_id = statement.id')
            ->innerJoin(StatementConsentCg::tableName() . ' consent', 'consent.statement_cg_id = cg.id')
            ->select($column)->groupBy($column)->all(), $column, $value);
    }

}