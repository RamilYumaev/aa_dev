<?php
namespace modules\entrant\widgets\cpk;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\File;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\models\UserCg;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\readRepositories\FileReadCozRepository;
use modules\entrant\readRepositories\ProfileFileReadRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class FileZIDWidget extends Widget
{
    public $view = "file-zid-new";
    public $eduLevel;

    public function run()
    {
        $query = StatementIa::find()
            ->joinWith('statementIndividualAchievement')->innerJoin(UserIndividualAchievements::tableName(),
                UserIndividualAchievements::tableName().'.individual_id=statement_ia.individual_id AND '.UserIndividualAchievements::tableName().'
             .user_id=statement_individual_achievements.user_id')
        ->innerJoin(OtherDocument::tableName(),
            'other_document.id='.UserIndividualAchievements::tableName().'.document_id')
        ->innerJoin(File::tableName(),
            'files.record_id=other_document.id')
            ->innerJoin(UserAis::tableName(),
                'user_ais.user_id=statement_individual_achievements.user_id')
            ->innerJoin(UserCg::tableName(), 'user_cg.user_id=statement_individual_achievements.user_id');
        $query->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=user_cg.cg_id');
        $query->innerJoin(Faculty::tableName(), 'dict_faculty.id=dict_competitive_group.faculty_id')
         ->andWhere(['files.model'=> OtherDocument::class])
            ->andWhere(['files.status' => FileHelper::STATUS_WALT])
            ->andWhere(['dict_faculty.filial'=>false])
            ->andWhere(['statement_individual_achievements.edu_level'=> $this->eduLevel])->distinct();
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => [
            'pageSize' =>  15,
        ],]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }

}
