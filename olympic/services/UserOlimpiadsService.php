<?php


namespace olympic\services;


use common\auth\models\User;
use common\auth\repositories\UserRepository;
use common\auth\repositories\UserSchoolRepository;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\helpers\SendingHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\repositories\SendingDeliveryStatusRepository;
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
        $this->transactionManager->wrap(function () use ($olympic_id, $user_id) {
            $olympic = $this->olimpicListRepository->get($olympic_id);
            $user = $this->userRepository->get($user_id);
            $userSchool = $this->userSchoolRepository->getSchooLUser($user->id);
            $this->classAndOlympicRepository->get($olympic->id, $userSchool->class_id);
            $userOlympic = UserOlimpiads::create($olympic->id, $userSchool->user_id);
            $this->repository->save($userOlympic);
            if ($olympic->isFormOfPassageInternal()) {
                $this->send($user, $olympic);
            }
        });
    }

    public function remove($id) {
        $userOlympic = $this->repository->get($id);
        $this->repository->remove($userOlympic);
    }

    private function send(User $user, OlimpicList $olympic) {
        $exit = $this->deliveryStatusRepository->
        getExits($user->id, SendingDeliveryStatusHelper::TYPE_OLYMPIC, $olympic->id,
            SendingDeliveryStatusHelper::TYPE_SEND_INVITATION);
        if (!$exit && $user->email) {
            try {
                $hash = \Yii::$app->security->generateRandomString() . '_' . time();
                $this->settingEmail($user, $olympic, $hash)->send();
                $delivery = SendingDeliveryStatus::create(null, $user->id, $hash,
                    SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                    SendingDeliveryStatusHelper::TYPE_SEND_INVITATION, $olympic->id);
                $this->deliveryStatusRepository->save($delivery);
                \Yii::$app->session->setFlash('success', 'Отправлено письмо приглашения на очный тур!.');
            } catch (\Swift_TransportException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
    }

    private function settingEmail(User $user, OlimpicList $olympic, $hash) {
        $mailer = \Yii::$app->olympicMailer;
        $mailer->olympic = $olympic->id;
        return $mailer
            ->mailer()
            ->compose()
            ->setFrom([$mailer->getFromSender() => \Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setTextBody($this->textEmail($user, $olympic, $hash, SendingHelper::TYPE_TEXT))
            ->setHtmlBody($this->textEmail($user, $olympic, $hash, SendingHelper::TYPE_HTML))
            ->setSubject('Приглашение ' . \Yii::$app->name);
    }

    private function textEmail(User $user, OlimpicList $olympic, $hash, $type) {
        $array = $olympic->replaceLabelsFromSending();
        array_unshift($array, ProfileHelper::profileName($user->id));
        array_push($array, "", "",  \yii\helpers\Url::to('@frontendInfo/invitation?hash='.$hash, true));
        $template = $type == SendingHelper::TYPE_HTML ? SendingHelper::htmlOlympic() : SendingHelper::textOlympic();
        return str_replace(SendingHelper::templatesLabel(), $array, $template);
    }
}