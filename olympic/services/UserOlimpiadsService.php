<?php


namespace olympic\services;


use common\auth\models\User;
use common\auth\repositories\UserRepository;
use common\auth\repositories\UserSchoolRepository;
use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\helpers\SendingHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\repositories\SendingDeliveryStatusRepository;
use common\sending\traits\MailTrait;
use common\transactions\TransactionManager;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;
use olympic\repositories\ClassAndOlympicRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\UserOlimpiadsRepository;

class UserOlimpiadsService
{
    private $repository;
    private $olimpicListRepository;
    private $classAndOlympicRepository;
    private $userSchoolRepository;
    private $deliveryStatusRepository;
    private $transactionManager;
    private $userRepository;

    use MailTrait;

    function __construct(UserOlimpiadsRepository $repository, OlimpicListRepository $olimpicListRepository,
                         ClassAndOlympicRepository $classAndOlympicRepository, UserSchoolRepository $userSchoolRepository,
                         SendingDeliveryStatusRepository $deliveryStatusRepository,
                         TransactionManager $transactionManager, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->classAndOlympicRepository = $classAndOlympicRepository;
        $this->userSchoolRepository = $userSchoolRepository;
        $this->deliveryStatusRepository = $deliveryStatusRepository;
        $this->transactionManager = $transactionManager;
        $this->userRepository = $userRepository;
    }

    public function add($olympic_id, $user_id) {
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        $this->transactionManager->wrap(function () use ($olympic_id, $user_id, $sendingTemplate) {
            $olympic = $this->olimpicListRepository->get($olympic_id);
            $user = $this->userRepository->get($user_id);
            $userSchool = $this->userSchoolRepository->getSchooLUser($user->id);
            $this->classAndOlympicRepository->get($olympic->id, $userSchool->class_id);
            $userOlympic = UserOlimpiads::create($olympic->id, $userSchool->user_id);
            $this->repository->save($userOlympic);
            if ($olympic->isFormOfPassageInternal()) {
                $this->send($user, $olympic, $this->deliveryStatusRepository,
                    SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                    SendingDeliveryStatusHelper::TYPE_SEND_INVITATION, null, $sendingTemplate);
            }
        });
    }

    public function remove($id) {
        $userOlympic = $this->repository->get($id);
        $this->repository->remove($userOlympic);
    }

    public function sendUser($id): void
    {
        $userOlympic = $this->repository->get($id);
        $user = $this->userRepository->get($userOlympic->user_id);
        if (is_null($user->email)) {
            throw new \DomainException('У данного пользователя  нет электронной почты.');
        }
        try {
            $this->transactionManager->wrap(function () use ($userOlympic, $user) {
                $userOlympic->setStatus(UserOlimpiads::WAIT);
                $userOlympic->generateVerificationToken();
                $userOlympic->setTeacher(\Yii::$app->user->identity->getId());
                $configTemplate = ['html' => 'verifyTeacherInUser-html', 'text' => 'verifyTeacherInUser-text'];
                $configData = ['userOlympic' => $userOlympic];
                $this->sendEmail($user, $configTemplate, $configData, 'Подтверждение. ');
                $this->repository->save($userOlympic);
            });
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error'," Ошибка сохранения");
        }
    }

    public function confirm($hash): void
    {
        $userOlympic = $this->repository->getHash($hash);
        $userOlympic->setStatus(UserOlimpiads::ACTIVE);
        $this->repository->save($userOlympic);
    }

    public function reset($hash): void
    {
        $userOlympic = $this->repository->getHash($hash);
        $userOlympic->setReset();
        $this->repository->save($userOlympic);
    }

    public function allUsersAjax($olympic)
    {
        $users = [];
        foreach (UserOlimpiads::find()->where(['olympiads_id'=>$olympic])->all() as $user ) {
            $users[] = [
                'id' => $user->user_id,
                'name' =>ProfileHelper::profileFullName($user->user_id) ,
            ];
        }
        return $users;
    }

}