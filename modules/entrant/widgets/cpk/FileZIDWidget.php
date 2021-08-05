<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\File;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
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
             'user-individual-achievements.individual_id=statement_ia.individual_id AND 
             user-individual-achievements.user_id=statement_individual_achievements.user_id')
        ->innerJoin(OtherDocument::tableName(),
            'other_document.id=user-individual-achievements.document_id')
        ->innerJoin(File::tableName(),
            'files.record_id=other_document.id')
            ->innerJoin(UserAis::tableName(),
                'user_ais.user_id=statement_individual_achievements.user_id')
         ->andWhere(['files.model'=> OtherDocument::class])
            ->andWhere(['files.status' => FileHelper::STATUS_WALT])
            ->andWhere(['edu_level'=> $this->eduLevel])->distinct();
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => [
            'pageSize' =>  15,
        ],]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }

}
