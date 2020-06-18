<?php


namespace modules\entrant\services;

use common\transactions\TransactionManager;
use modules\dictionary\models\DictOrganizations;
use modules\dictionary\repositories\DictOrganizationsRepository;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisReturnData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\UserAis;
use modules\entrant\repositories\AgreementRepository;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementConsentCgRepository;
use modules\entrant\repositories\StatementIndividualAchievementsRepository;
use modules\entrant\repositories\StatementRejectionCgConsentRepository;
use modules\entrant\repositories\StatementRejectionCgRepository;
use modules\entrant\repositories\StatementRejectionRepository;
use modules\entrant\repositories\StatementRepository;
use modules\usecase\RepositoryDeleteSaveClass;
use Mpdf\Tag\Tr;
use olympic\models\auth\Profiles;
use olympic\repositories\auth\ProfileRepository;

class UserAisService
{
    private $repository;
    private $transactionManager;
    private $statementRepository;
    private $consentCgRepository;
    private $individualAchievementsRepository;
    private $rejectionCgConsentRepository;
    private $statementRejectionRepository;
    private $statementRejectionCgRepository;
    private $agreementRepository;
    private $organizationsRepository;
    private $statementCgRepository;
    private $profileRepository;


    public function __construct(RepositoryDeleteSaveClass $repository,
                                TransactionManager $transactionManager,
                                StatementRepository $statementRepository,
                                StatementIndividualAchievementsRepository $individualAchievementsRepository,
                                StatementConsentCgRepository $consentCgRepository,
                                StatementRejectionCgConsentRepository $rejectionCgConsentRepository,
                                StatementRejectionRepository $statementRejectionRepository,
                                StatementRejectionCgRepository $statementRejectionCgRepository,
                                StatementCgRepository $statementCgRepository,
                                AgreementRepository $agreementRepository,
                                DictOrganizationsRepository $organizationsRepository,
                                ProfileRepository $profileRepository)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
        $this->consentCgRepository = $consentCgRepository;
        $this->statementRepository = $statementRepository;
        $this->individualAchievementsRepository = $individualAchievementsRepository;
        $this->rejectionCgConsentRepository = $rejectionCgConsentRepository;
        $this->statementRejectionRepository = $statementRejectionRepository;
        $this->statementRejectionCgRepository = $statementRejectionCgRepository;
        $this->agreementRepository = $agreementRepository;
        $this->organizationsRepository = $organizationsRepository;
        $this->statementCgRepository = $statementCgRepository;
        $this->profileRepository = $profileRepository;
    }

    public function create($userId, $data, $createdId)
    {
        $this->transactionManager->wrap(function () use ($userId, $data, $createdId) {
            $model = UserAis::create($userId, $data['incoming_id']);
            $this->repository->save($model);
            $this->dataAis($data, $createdId, $model->incoming_id);
        });
    }

    public function addData($model, $id, $email_id)
    {
        $this->transactionManager->wrap(function () use ($model, $id, $email_id) {
            $this->statusSuccess($model, $id, $email_id);
        });
    }

    public function agreement($id, $aisId)
    {
        $this->transactionManager->wrap(function () use ($id, $aisId) {
            $agreement = $this->agreementRepository->get($id);
            $org = $this->organizationsRepository->get($agreement->organization_id);
            $org->setAisId($aisId);

            $this->organizationsRepository->save($org);
            foreach ($agreement->statement as $statement) {
                $statementId = $this->statementRepository->get($statement->id);
                $statementId->setStatus(StatementHelper::STATUS_WALT);
                $this->statementRepository->save($statementId);
            }
            $agreement->detachBehavior('moderation');

            $this->agreementRepository->save($agreement);
        });
    }


    public function removeZos($id)
    {
        $this->transactionManager->wrap(function () use ($id) {
            $zosRemove = $this->rejectionCgConsentRepository->get($id);
            $zos = $this->consentCgRepository->get($zosRemove->statement_cg_consent_id);
            $zos->setStatus(StatementHelper::STATUS_RECALL);
            $zosRemove->setStatus(StatementHelper::STATUS_ACCEPTED);


            $this->rejectionCgConsentRepository->save($zosRemove);
            $this->consentCgRepository->save($zos);
        });
    }

    public function removeZuk($id)
    {
        $this->transactionManager->wrap(function () use ($id) {
            $zukRemove = $this->statementRejectionRepository->get($id);
            $zuk = $this->statementRepository->get($zukRemove->statement->id);
            $zuk->setStatus(StatementHelper::STATUS_RECALL);
            $zukRemove->setStatus(StatementHelper::STATUS_ACCEPTED);
            foreach ($zuk->statementCg as $value) {
                foreach ($value->statementConsent as $item) {
                    /* @var $item  StatementConsentCg */
                    $item->setStatus(StatementHelper::STATUS_RECALL);
                    $this->consentCgRepository->save($item);
                }
            }
            $this->statementRejectionRepository->save($zukRemove);
            $this->statementRepository->save($zuk);
        });
    }

    public function removeZukCg($id)
    {
        $this->transactionManager->wrap(function () use ($id) {
        $zukCgRemove = $this->statementRejectionCgRepository->get($id);
        $zukCgRemove->setStatus(StatementHelper::STATUS_ACCEPTED);
        /* @var $stCg StatementCg */
        $stCg = $zukCgRemove->statementCg;
        $stCg->setStatus(1);
        foreach ($stCg->statementConsent as $item) {
            /* @var $item  StatementConsentCg */
            $item->setStatus(StatementHelper::STATUS_RECALL);
            $this->consentCgRepository->save($item);
        }
        $this->statementRejectionCgRepository->save($zukCgRemove);

        $this->statementCgRepository->save($stCg);
        });
    }

    private function dataAis($data, $createdId, $incomingId)
    {
        if (key_exists('documents', $data)) {
            foreach ($data['documents'] as $type => $value) {
                foreach ($value as $item) {
                    $aisData = AisReturnData::create($createdId,
                        AisReturnDataHelper::modelKey($type), $type, $incomingId, $item['sdo_id'], $item['ais_id']);
                    $this->repository->save($aisData);
                }
            }
        }
    }

    private function statusSuccess($model, $id, $email_id)
    {
        if ($model == Statement::class) {
            $statement = $this->statementRepository->get($id);
            $statement->setStatus(StatementHelper::STATUS_ACCEPTED);
            $this->statementRepository->save($statement);
            $text = $statement->textEmail;
            $user = $statement->user_id;
            $this->successSend($email_id, $user, $text);
        } elseif ($model == StatementConsentCg::class) {
            $statement = $this->consentCgRepository->get($id);
            $statement->setStatus(StatementHelper::STATUS_ACCEPTED);
            $this->consentCgRepository->save($statement);
            $text = $statement->textEmail;
            $user = $statement->statementCg->statement->user_id;
            $this->successSend($email_id, $user, $text);
        } elseif ($model == StatementIndividualAchievements::class) {
            $statement = $this->individualAchievementsRepository->get($id);
            $statement->setStatus(StatementHelper::STATUS_ACCEPTED);
            $this->individualAchievementsRepository->save($statement);
            $text = $statement->textEmail;
            $user = $statement->user_id;
            $this->successSend($email_id, $user, $text);
        }


    }


    public function successSend($email_id, $user_id,  $text)
    {
        $profile = $this->profileRepository->getUser($user_id);
        try {
            $this->sendEmailSuccess($email_id, $profile, $text)->send();
            \Yii::$app->session->setFlash('success', 'Отправлено.');
        } catch (\Swift_TransportException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    private function sendEmailSuccess($emailId, Profiles $profile, $text)
    {
        $mailer = \Yii::$app->selectionCommitteeMailer;
        $mailer->idSettingEmail = $emailId;

        $configTemplate =  ['html' => 'successEntrant-html', 'text' => 'successEntrant-text'];
        $configData = ['profile' => $profile, 'text'=>$text];
        return $mailer
            ->mailer()
            ->compose($configTemplate, $configData)
            ->setFrom([$mailer->getFromSender() => \Yii::$app->name . ' robot'])
            ->setTo($profile->user->email)

            ->setSubject('Проверка ' . \Yii::$app->name);
    }




}