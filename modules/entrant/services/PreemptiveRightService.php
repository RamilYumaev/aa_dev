<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\dictionary\models\DictIncomingDocumentType;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\forms\PreemptiveRightMessageForm;
use modules\entrant\helpers\PreemptiveRightHelper;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PreemptiveRight;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\PreemptiveRightRepository;

class PreemptiveRightService
{
    private $repositoryDocument;
    private $preemptiveRightRepository;
    private $manager;

    public function __construct(OtherDocumentRepository $repositoryDocument, TransactionManager $manager, PreemptiveRightRepository $preemptiveRightRepository)
    {

        $this->repositoryDocument = $repositoryDocument;
        $this->preemptiveRightRepository = $preemptiveRightRepository;
        $this->manager = $manager;
    }

    public function create(OtherDocumentForm $form, $type)
    {
        $this->manager->wrap(function () use ($form, $type) {
            $document = OtherDocument::create($form);
            $this->repositoryDocument->save($document);

            $preemptiveRight = PreemptiveRight::create($document->id, $type, null);
            $this->preemptiveRightRepository->save($preemptiveRight);

        });
    }

    public function add($otherDocumentId, $type)
    {
        $otherDocument =  $this->repositoryDocument->get($otherDocumentId);
        $this->preemptiveRightRepository->isPreemptive($otherDocument->id, $type);
        $preemptiveRight = PreemptiveRight::create($otherDocumentId, $type, null);
        $this->preemptiveRightRepository->save($preemptiveRight);
    }

    public function remove($otherDocumentId, $type)
    {
        $model = $this->preemptiveRightRepository->get($otherDocumentId, $type);
        $this->preemptiveRightRepository->remove($model);
    }

    public function addMessage($otherDocumentId, $type, PreemptiveRightMessageForm $form)
    {
        $model = $this->preemptiveRightRepository->get($otherDocumentId, $type);
        $model->setMessage($form->message);
        $model->setStatus(PreemptiveRightHelper::DANGER);
        $this->preemptiveRightRepository->save($model);
    }

    public function status($otherDocumentId, $type, $status)
    {
        $model = $this->preemptiveRightRepository->get($otherDocumentId, $type);
        $model->setStatus($status);
        $this->preemptiveRightRepository->save($model);
    }


}