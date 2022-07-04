<?php


namespace modules\entrant\services;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\StatementRepository;
use modules\superservice\forms\DocumentsDynamicForm;
use yii\base\DynamicModel;

class OtherDocumentService
{
    private $repository;
    private $statementRepository;

    public function __construct(OtherDocumentRepository $repository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->statementRepository = $statementRepository;
    }

    public function create(OtherDocumentForm $form)
    {
        $model  = OtherDocument::create($form);
        $model->versionData($form);
        if($form->other_data) {
            $model->otherData($form->other_data);
        }
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, OtherDocumentForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->versionData($form);
        if($form->other_data) {
            $model->otherData($form->other_data);
        }
        else {
            $model->other_data = null;
        }
        if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
            $model->detachBehavior("moderation");
        }
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        if($model->type_note || $model->type == DictIncomingDocumentTypeHelper::ID_PATRIOT_DOC) {
            throw new \DomainException('Вы не можеете, удалить данный прочий документ, так как он необходим для загрузки файла');
        }
        $this->repository->remove($model);
    }

}