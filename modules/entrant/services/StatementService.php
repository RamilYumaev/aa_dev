<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\Statement;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\StatementRepository;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class StatementService
{
    private $repository;
    private $manager;

    public function __construct(StatementRepository $repository, TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function create(array $cgUser, $type, $user_id)
    {
        $this->manager->wrap(function () use ($cgUser, $type, $user_id) {
            foreach ($cgUser as $cg) {
                $model = Statement::find();
                $max = $model->lastMaxCounter($cg->faculty_id,
                    $cg->speciality_id,
                    $cg->special_right_id,
                    $cg->edu_level,
                    $type);
                $exits =$model->statementUser($cg->faculty_id,
                    $cg->speciality_id,
                    $cg->special_right_id,
                    $cg->edu_level,
                    $type,
                    $user_id);
                if(!$exits) {
                    $statement = Statement::create($user_id, $cg->faculty_id,
                        $cg->speciality_id,
                        $cg->special_right_id,
                        $cg->edu_level,
                        $type, ++$max);
                    $this->repository->save($statement);
                }
            }
        });
    }

    public function saveModel($type, $user_id)
    {
//        if(($model = $this->repository->getUser($user_id)) !== null) {
//            $model->data($type, $user_id);
//        }else {
//            $model= Statement::create($type, $user_id);
//        }
//        $this->repository->save($model);
    }


}