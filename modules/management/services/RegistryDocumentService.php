<?php


namespace modules\management\services;


use modules\management\migrations\m191208_001260_add_columns_registry_document;
use modules\management\models\DocumentTask;
use modules\management\models\RegistryDocument;
use modules\management\repositories\DocumentTaskRepository;
use modules\management\repositories\RegistryDocumentRepository;
use modules\usecase\ServicesClass;
use yii\base\Model;


class RegistryDocumentService extends ServicesClass
{
    private $documentTaskRepository;

    public function __construct(RegistryDocumentRepository $repository, RegistryDocument $model,
                                DocumentTaskRepository $documentTaskRepository)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->documentTaskRepository = $documentTaskRepository;
    }

    public function createForTask(Model $form, $task_id)
    {
        $model = $this->create($form);
        $this->createDocumentTask($model->id, $task_id);
    }

    public function handleDocumentTask($documentId, $task_id, $bool) {
        if($bool == 'true') {
            $this->createDocumentTask($documentId, $task_id);
            return "Добавлен!";
        }
        else {
            $this->deleteDocumentTask($documentId, $task_id);
            return "Удален!";
        }
    }

    private function createDocumentTask($documentId,$task_id) {
        $documentTask = DocumentTask::findOne(['document_registry_id' => $documentId, 'task_id' => $task_id]);
        if($documentTask) {
            throw new \DomainException("Такой документ существует");
        }
        $documentTask = DocumentTask::create($documentId, $task_id);
        $this->documentTaskRepository->save($documentTask);
    }

    private function deleteDocumentTask($documentId,$task_id) {
        $documentTask = DocumentTask::findOne(['document_registry_id' => $documentId, 'task_id' => $task_id]);
        if(!$documentTask) {
            throw new \DomainException("Не найден документ к данной задаче");
        }

        $this->documentTaskRepository->remove($documentTask);
    }

}