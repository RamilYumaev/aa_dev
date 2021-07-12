<?php


namespace modules\entrant\services;


use common\helpers\EduYearHelper;
use common\transactions\TransactionManager;
use modules\dictionary\models\DictOrganizations;
use modules\dictionary\repositories\DictOrganizationsRepository;
use modules\entrant\forms\AgreementForm;
use modules\entrant\forms\AgreementMessageForm;
use modules\entrant\helpers\AgreementHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\OtherDocument;
use modules\entrant\repositories\AgreementRepository;
use modules\entrant\repositories\StatementRepository;
use Mpdf\Tag\A;
use Mpdf\Tag\Tr;

class AgreementService
{
    private $repository;
    private $organizationsRepository;
    private $transactionManager;
    private $statementRepository;

    public function __construct(AgreementRepository $repository,
                                DictOrganizationsRepository $organizationsRepository,
                                StatementRepository $statementRepository,
                                TransactionManager $transactionManager
    )
    {
        $this->repository = $repository;
        $this->organizationsRepository = $organizationsRepository;
        $this->transactionManager = $transactionManager;
        $this->statementRepository = $statementRepository;
    }

    public function createOrUpdate(AgreementForm $form, Agreement $model)
    {
        $agreement = $this->repository->get($model->id);
        $agreement->data($form);
        if(!$this->statementRepository->getStatementStatusNoDraft($agreement->user_id) ) {
            $agreement->detachBehavior("moderation");
        }
        $this->repository->save($agreement);
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id)
    {
        $model = $this->repository->get($id);
        if($model->getStatementTarget()->exists()) {
            throw new \DomainException('Нельзя удалить договор, так как есть ЗУКи на целевое обучение');
        }
        $other = OtherDocument::findOne(['user_id'=> $model->user_id, 'type_note' => OtherDocumentHelper::STATEMENT_TARGET]);
        if($other) {
            $other->delete();
        }
        $this->repository->remove($model);
    }

    public function addMessage($id, AgreementMessageForm $form)
    {
        $model = $this->repository->get($id);
        $model->detachBehavior('moderation');
        $model->setStatus(AgreementHelper::STATUS_NO_ACCEPTED);
        $model->setMessage($form->message);
        $this->repository->save($model);
    }

    public function addStatus($id)
    {
        $model = $this->repository->get($id);
        $model->detachBehavior('moderation');
        $model->setStatus(AgreementHelper::STATUS_VIEW);
        $this->repository->save($model);
    }

    public function addOrganization($id, $status, $userId, Agreement $agreement = null)
    {
        $organization = $this->organizationsRepository->get($id);
        if($status == 0) {
            $org = $organization->id;
            $work = $agreement ? $agreement->work_organization_id : null;
        }elseif ($status == 1) {
            $org = $agreement ? $agreement->organization_id : null;
            $work = $organization->id;
        }else {
            $org = $organization->id;
            $work = $organization->id;
        }
        if($agreement) {
            $agreement->addOrganization($org, $work);
        } else {
            $agreement  = new Agreement();
            $agreement->addOrganization($org, $work);
            $agreement->user_id = $userId;
            $agreement->year  = EduYearHelper::eduYear();
        }
        if(!$this->statementRepository->getStatementStatusNoDraft($agreement->user_id) ) {
            $agreement->detachBehavior("moderation");
        }

        $this->repository->save($agreement);
    }


}