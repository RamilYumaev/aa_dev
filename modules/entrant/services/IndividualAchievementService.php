<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\dictionary\helpers\DictIndividualAchievementCgHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\StatementIaRepository;
use modules\entrant\repositories\StatementIndividualAchievementsRepository;

class IndividualAchievementService
{
    private $repositoryDocument;
    private $repositoryUserIa;
    private $manager;
    private $individualAchievementsRepository;
    private $iaRepository;

    public function __construct(OtherDocumentRepository $repositoryDocument,
                                IndividualAchievementsRepository $repositoryUserIa,
                                StatementIndividualAchievementsRepository $individualAchievementsRepository,
                                StatementIaRepository $iaRepository,
                                TransactionManager $manager)
    {

        $this->repositoryDocument = $repositoryDocument;
        $this->repositoryUserIa = $repositoryUserIa;
        $this->iaRepository = $iaRepository;
        $this->individualAchievementsRepository = $individualAchievementsRepository;
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

    public function update($otherDoc, OtherDocumentForm $form)
    {
        $this->manager->wrap(function () use ($form, $otherDoc) {
            $document = $this->repositoryDocument->get($otherDoc);
            $document->data($form);
            $this->repositoryDocument->save($document);
        });
    }

    public function remove($id)
    {
        $this->manager->wrap(function () use ($id) {
            $model = $this->repositoryUserIa->get($id);
            $modelDocument = $this->repositoryDocument->get($model->document_id);
            $statementIa = $this->iaRepository->getUserStatement($model->individual_id, $model->user_id);
            if($statementIa) {
                if ($statementIa->statementIndividualAchievement->files) {
                    throw new \DomainException('Сначала удалите скан-копии заявления об учете индивидуальных достижений!');
                }
                $statement = $this->individualAchievementsRepository->get($statementIa->statement_individual_id);
                if($statement->getStatementIa()->count() == 1) {
                    $this->individualAchievementsRepository->remove($statement);
                }else {
                    $this->iaRepository->remove($statementIa);
                }
            }
            $this->repositoryUserIa->remove($model);
            $this->repositoryDocument->remove($modelDocument);

        });
    }

}