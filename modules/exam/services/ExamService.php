<?php


namespace modules\exam\services;

use modules\dictionary\models\DictForeignLanguage;
use modules\dictionary\repositories\DictForeignLanguageRepository;
use modules\entrant\forms\LanguageForm;
use modules\entrant\models\Language;
use modules\entrant\repositories\LanguageRepository;
use modules\entrant\repositories\StatementRepository;
use modules\exam\forms\ExamForm;
use modules\exam\models\Exam;
use modules\exam\repositories\ExamRepository;

class ExamService
{
    private $repository;
    private $dictForeignLanguageRepository;

    public function __construct(ExamRepository $repository,
                                DictForeignLanguageRepository $dictForeignLanguageRepository)
    {
        $this->repository = $repository;
        $this->dictForeignLanguageRepository = $dictForeignLanguageRepository;
    }

    public function create(ExamForm $form)
    {
        $model  = Exam::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, ExamForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}