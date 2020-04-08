<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\SubmittedDocumentsRepository;

class SubmittedDocumentsService
{
    private $repository;
    private $manager;

    public function __construct(SubmittedDocumentsRepository $repository, TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function create($type, $user_id)
    {
        $this->manager->wrap(function () use ($type, $user_id) {
            $this->saveModel($type, $user_id);
        });
    }

    public function saveModel($type, $user_id)
    {
        if(($model = $this->repository->getUser($user_id)) !== null) {
            $model->data($type, $user_id);
        }else {
            $model= SubmittedDocuments::create($type, $user_id);
        }
        $this->repository->save($model);
    }


}