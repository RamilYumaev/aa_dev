<?php

namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\models\PassportData;
use modules\entrant\repositories\PassportDataRepository;
use modules\entrant\repositories\StatementRepository;


class PassportDataService
{
    private $repository;
    private $transactionManager;
    private $statementRepository;

    public function __construct(PassportDataRepository $repository, TransactionManager $transactionManager, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
        $this->statementRepository = $statementRepository;

    }

    public function create(PassportDataForm $form, $birthDocument = false)
    {
        $this->transactionManager->wrap(function () use ($form, $birthDocument) {
            if ($birthDocument) {
                if ($form->nationality == DictCountryHelper::RUSSIA) {
                    $form->type = DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT;
                } else {
                    $form->type = DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT;

                }
            }

            $model = PassportData::create($form, $this->mainStatusDefaultForm($form, $birthDocument));
            $this->repository->save($model);
        });

    }

    public function edit($id, PassportDataForm $form, $birthDocument = false)
    {
        $this->transactionManager->wrap(function () use ($id, $form, $birthDocument) {
            if ($birthDocument) {
                if ($form->nationality == DictCountryHelper::RUSSIA) {
                    $form->type = DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT;
                } else {
                    $form->type = DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT;

                }
            }
            $model = $this->repository->get($id);
            $model->data($form, $model->main_status);
            if (!$this->statementRepository->getStatementStatusNoDraft($model->user_id)) {
                $model->detachBehavior("moderation");
            }
            $this->repository->save($model);
        });
    }

    private function mainStatusDefaultForm(PassportDataForm $form, $birthDocument = false)
    {
        if ($birthDocument) {
            return false;
        }
        return PassportData::find()->where(['main_status' => DictDefaultHelper::YES, 'user_id' => $form->user_id])->exists() ? false : true;
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}