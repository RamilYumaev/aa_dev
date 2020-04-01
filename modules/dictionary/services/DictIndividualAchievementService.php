<?php
namespace modules\dictionary\services;

use common\transactions\TransactionManager;
use modules\dictionary\forms\DictIndividualAchievementForm;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\models\DictIndividualAchievementCg;
use modules\dictionary\models\DictIndividualAchievementDocument;
use modules\dictionary\repositories\DictIndividualAchievementCgRepository;
use modules\dictionary\repositories\DictIndividualAchievementDocumentRepository;
use modules\dictionary\repositories\DictIndividualAchievementRepository;
use modules\usecase\RepositoryDeleteSaveClass;

class DictIndividualAchievementService
{
    private $repository;
    private $transactionManager;
    private $documentRepository;
    private $cgRepository;


    public function __construct(DictIndividualAchievementRepository $repository,
                                TransactionManager $transactionManager,
                                DictIndividualAchievementDocumentRepository $documentRepository,
                                DictIndividualAchievementCgRepository $cgRepository)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
        $this->cgRepository = $cgRepository;
        $this->documentRepository = $documentRepository;
    }

    public function create(DictIndividualAchievementForm $form)
    {
        $model  = DictIndividualAchievement::create($form);
        $this->transactionManager->wrap(function () use ($model, $form) {
            $this->repository->save($model);
            $this->saveCgAndDocument($form, $model->id);
        });
        return $model;
    }

    public function edit($id, DictIndividualAchievementForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $this->transactionManager->wrap(function () use ($model, $form) {
            $this->deleteRelation($model->id);
            $this->saveCgAndDocument($form, $model->id);
            $this->repository->save($model);
        });

    }

    private function saveCgAndDocument(DictIndividualAchievementForm $form, $id) {
        if ($form->competitiveGroupsList) {
            foreach ($form->competitiveGroupsList as $cg) {
                $cg= DictIndividualAchievementCg::create($id, $cg);
                $this->cgRepository->save($cg);
            }
        }
        if ($form->documentTypesList) {
            foreach ($form->documentTypesList as $item) {
                $document= DictIndividualAchievementDocument::create($id, $item);
                $this->documentRepository->save($document);
            }
        }
    }

    private function deleteRelation($id)
    {
        DictIndividualAchievementDocument::deleteAll(['individual_achievement_id' => $id]);
        DictIndividualAchievementCg::deleteAll(['individual_achievement_id' => $id]);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->deleteRelation($model->id);
        $this->repository->remove($model);
    }

}