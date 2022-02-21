<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\dictionary\models\DictCategory;
use modules\entrant\behaviors\AnketaBehavior;
use modules\entrant\forms\AnketaForm;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\OtherDocument;
use modules\entrant\repositories\AnketaRepository;
use modules\entrant\repositories\OtherDocumentRepository;

class AnketaService
{
    private $repository;
    private $otherDocumentRepository;
    private $transactionManager;

    public function __construct(AnketaRepository $repository, OtherDocumentRepository $otherDocumentRepository, TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->otherDocumentRepository = $otherDocumentRepository;
        $this->transactionManager = $transactionManager;
    }

    public function create(AnketaForm $form)
    {
        $model = Anketa::create($form);
        $this->repository->save($model);
        $this->addOtherDoc($form);
        return $model;
    }

    public function update($id, AnketaForm $form, $isAdmin = false)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        if($isAdmin) {
            $model->detachBehaviors();
        }
        $model->save($model);
        $this->addOtherDoc($form);
        return $model;
    }

    private function addOtherDoc(AnketaForm $form) {
        $other = $this->otherDocumentRepository->getUserNote($form->user_id, OtherDocumentHelper::TRANSLATION_PASSPORT);
        $otherTPGU = $this->otherDocumentRepository->getUserNote($form->user_id, OtherDocumentHelper::STATEMENT_AGREE_TPGU);
        if ($form->citizenship_id != DictCountryHelper::RUSSIA)  {
            if(!$other) {
                $this->otherDocumentRepository->save(OtherDocument::createNote(
                    OtherDocumentHelper::TRANSLATION_PASSPORT, DictIncomingDocumentTypeHelper::ID_AFTER_DOC, $form->user_id,null ));
            }
        } else {
            if($other) {
                $this->otherDocumentRepository->remove($other);
            }
        }
        if($form->category_id == CategoryStruct::TPGU_PROJECT){
            if(!$otherTPGU){
                $this->otherDocumentRepository->save(OtherDocument::createNote(
                    OtherDocumentHelper::STATEMENT_AGREE_TPGU, DictIncomingDocumentTypeHelper::ID_AFTER_DOC, $form->user_id,null ));
            }

        }else {
            if ($otherTPGU) {
                $this->otherDocumentRepository->remove($otherTPGU);
            }
        }

    }



    public function category($foreignerStatus)
    {
        $category = DictCategory::find()
            ->andWhere(['foreigner_status' => $foreignerStatus])
            ->all();

        $result = [];

        foreach ($category as $item)
        {
            $result[] = [
                'id' => $item->id,
                'text' => $item->name,
                ];

        }
        return $result;


    }

}