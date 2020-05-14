<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\dictionary\helpers\DictIndividualAchievementCgHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\OtherDocumentRepository;

class IndividualAchievementService
{
    private $repositoryDocument;
    private $repositoryUserIa;
    private $manager;

    public function __construct(OtherDocumentRepository $repositoryDocument,
                                IndividualAchievementsRepository $repositoryUserIa, TransactionManager $manager)
    {

        $this->repositoryDocument = $repositoryDocument;
        $this->repositoryUserIa = $repositoryUserIa;
        $this->manager = $manager;
    }

    public function create($individualId, OtherDocumentForm $form)
    {
        $this->manager->wrap(function () use ($form, $individualId) {

            if(!in_array($individualId, DictIndividualAchievementCgHelper::dictIndividualAchievementCgUserColumn($form->user_id))) {
                throw new \DomainException('Такое индивидуальное достижение вы не можете добавить!.');
            }
            $this->repositoryUserIa->isIndividual($form->user_id, $individualId);
            $document = OtherDocument::create($form);
            $this->repositoryDocument->save($document);

            $individual = UserIndividualAchievements::create($form->user_id, $individualId, $document->id);
            $this->repositoryUserIa->save($individual);

        });
    }

    public function remove($id)
    {
        $this->manager->wrap(function () use ($id) {
            $model = $this->repositoryUserIa->get($id);
            $modelDocument = $this->repositoryDocument->get($model->document_id);
            $this->repositoryUserIa->remove($model);
            $this->repositoryDocument->remove($modelDocument);
        });
    }

}