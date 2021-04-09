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
use common\user\repositories\TeacherClassUserRepository;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;
use olympic\repositories\ClassAndOlympicRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\UserOlimpiadsRepository;
use teacher\helpers\TeacherClassUserHelper;
use teacher\models\TeacherClassUser;

class UserOlimpiadsService
{
    private $repository;
    private $olimpicListRepository;
    private $classAndOlympicRepository;
    private $userSchoolRepository;
    private $deliveryStatusRepository;
    private $transactionManager;
    private $userRepository;
    private $teacherClassUserRepository;

    use MailTrait;

    function __construct(UserOlimpiadsRepository $repository, OlimpicListRepository $olimpicListRepository,
                         ClassAndOlympicRepository $classAndOlympicRepository, UserSchoolRepository $userSchoolRepository,
                         SendingDeliveryStatusRepository $deliveryStatusRepository,
                         TransactionManager $transactionManager, UserRepository $userRepository,
                         TeacherClassUserRepository $teacherClassUserRepository)
    {
        $this->repository = $repository;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->classAndOlympicRepository = $classAndOlympicRepository;
        $this->userSchoolRepository = $userSchoolRepository;
        $this->deliveryStatusRepository = $deliveryStatusRepository;
        $this->transactionManager = $transactionManager;
        $this->userRepository = $userRepository;
        $this->teacherClassUserRepository = $teacherClassUserRepository;
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
            if(!$this->repository->isUserOlympic($olympic->id, $user->id)) {
                $userOlympic = UserOlimpiads::create($olympic->id, $userSchool->user_id);
                $this->repository->save($userOlympic);
            }
            if ($olympic->isFormOfPassageInternal()) {
                $this->send($user, $olympic, $this->deliveryStatusRepository,
                    SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                    SendingDeliveryStatusHelper::TYPE_SEND_INVITATION, null, $sendingTemplate);
            }
        });
    }

    /**
     * @param $olympic_id
     * @param $user_id
     * @throws \yii\web\HttpException
     */
    public function addVolunteering($olympic_id, $user_id) {
        $olympic = $this->olimpicListRepository->get($olympic_id);
        $user = $this->userRepository->get($user_id);
        if(!$this->repository->isUserOlympic($olympic->id, $user->id)) {
            $userOlympic = UserOlimpiads::create($olympic->id, $user->id);
            $this->repository->save($userOlympic);
        }
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
                $userTeacherClass = TeacherClassUser::create($userOlympic->id);
                $userTeacherClass->setStatus(TeacherClassUserHelper::ACTIVE);
                $userTeacherClass->generateVerificationToken();
                $configTemplate = ['html' => 'verifyTeacherInUser-html', 'text' => 'verifyTeacherInUser-text'];
                $configData = ['userOlympic' => $userOlympic, 'hash'=> $userTeacherClass->hash,
                    'teacher_id' =>\Yii::$app->user->identity->getId()];
                $this->sendEmail($user, $configTemplate, $configData, 'Запрос информации. ');
                $this->teacherClassUserRepository->save($userTeacherClass);
            });
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error'," Ошибка сохранения");
        }
    }

    public function confirm($hash): void
    {
        $userTeacherClass = $this->teacherClassUserRepository->getHash($hash);
        $userTeacherClass->setStatus(TeacherClassUserHelper::ACTIVE);
        $userOlympic = $userTeacherClass->getOlympicUserOne();
        if($userOlympic->olympicUserDiploma()) {
            $user = $this->userRepository->get($userTeacherClass->user_id);
            $this->sendTeacher($user, $userOlympic->olympiads_id, $userTeacherClass->id);
        }
        $this->teacherClassUserRepository->save($userTeacherClass);
    }

    public function sendTeacher(User $user, $olympic, $gratitude_id) {
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_GRATITUDE)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        $olympic = $this->olimpicListRepository->get($olympic);
        $this->send($user, $olympic, $this->deliveryStatusRepository,
            SendingDeliveryStatusHelper::TYPE_OLYMPIC,
            SendingDeliveryStatusHelper::TYPE_SEND_GRATITUDE, null, $sendingTemplate, $gratitude_id);
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