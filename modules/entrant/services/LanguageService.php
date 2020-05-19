<?php


namespace modules\entrant\services;

use modules\dictionary\models\DictForeignLanguage;
use modules\dictionary\repositories\DictForeignLanguageRepository;
use modules\entrant\forms\LanguageForm;
use modules\entrant\models\Language;
use modules\entrant\repositories\LanguageRepository;
use modules\entrant\repositories\StatementRepository;

class LanguageService
{
    private $repository;
    private $dictForeignLanguageRepository;
    private $statementRepository;

    public function __construct(LanguageRepository $repository,
                                DictForeignLanguageRepository $dictForeignLanguageRepository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->dictForeignLanguageRepository = $dictForeignLanguageRepository;
        $this->statementRepository = $statementRepository;
    }

    public function create(LanguageForm $form)
    {
        $this->dictForeignLanguageRepository->get($form->language_id);
        $model  = Language::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, LanguageForm $form)
    {
        $this->dictForeignLanguageRepository->get($form->language_id);
        $model = $this->repository->get($id);
        $model->data($form);
        if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
            $model->detachBehavior("moderation");
        }
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}