<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
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
            $document = OtherDocument::create($form);
            $this->repositoryDocument->save($document);

            $individual = UserIndividualAchievements::create($form->user_id, $individualId, $document->id);
            $this->repositoryUserIa->save($individual);

        });
    }



}