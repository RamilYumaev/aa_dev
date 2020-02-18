<?php


namespace olympic\services;

use common\auth\models\UserSchool;
use common\helpers\FlashMessages;
use common\sending\traits\MailTrait;
use common\transactions\TransactionManager;
use common\user\repositories\UserTeacherSchoolRepository;
use dictionary\repositories\DictClassRepository;
use dictionary\repositories\DictSchoolsRepository;
use olympic\forms\auth\SchooLUserCreateForm;
use common\auth\repositories\UserSchoolRepository;
use olympic\helpers\auth\ProfileHelper;
use olympic\repositories\UserOlimpiadsRepository;
use olympic\traits\NewOrRenameSchoolTrait;
use teacher\helpers\UserTeacherJobHelper;
use teacher\models\UserTeacherJob;

class UserSchoolService
{

    use NewOrRenameSchoolTrait;
    use MailTrait;
    private $userSchoolRepository;
    private $classRepository;
    public $schoolsRepository;
    public $teacherSchoolRepository;
    private $transactionManager;
    private $userOlimpiadsRepository;

    public function __construct(
        UserOlimpiadsRepository $userOlimpiadsRepository,
        UserSchoolRepository $userSchoolRepository,
        DictClassRepository $classRepository,
        DictSchoolsRepository $schoolsRepository,
        UserTeacherSchoolRepository $teacherSchoolRepository,
        TransactionManager $transactionManager
    )
    {
        $this->userSchoolRepository = $userSchoolRepository;
        $this->schoolsRepository = $schoolsRepository;
        $this->classRepository = $classRepository;
        $this->teacherSchoolRepository = $teacherSchoolRepository;
        $this->transactionManager = $transactionManager;
        $this->userOlimpiadsRepository = $userOlimpiadsRepository;
    }

    public function signup(SchooLUserCreateForm $form, $role): void
    {
        if ($role == ProfileHelper::ROLE_TEACHER) {
            $teacher = $this->newUserTeacherSchool($form, \Yii::$app->user->id);
            $this->teacherSchoolRepository->save($teacher);
            $school = $this->schoolsRepository->get($teacher->school_id);
            if ($school->isStatusAndEmail()) {
                $this->send($teacher->id, \Yii::$app->user->id);
                \Yii::$app->session->setFlash('success', 'Письмо отправлено!');
            }
        } else {
            $userSchool = $this->newUserSchool($form, $form->schoolUser->class_id, \Yii::$app->user->id);
            $this->userSchoolRepository->save($userSchool);
        }
    }

    public function update($id, SchooLUserCreateForm $form, $role): void
    {
        if ($role == ProfileHelper::ROLE_TEACHER) {
            $this->teacherSchoolRepository->save($this->updateUserTeacherSchool($id, $form, \Yii::$app->user->id));
        }else {
            $userSchool = $this->updateUserSchool($id, $form, $form->schoolUser->class_id, \Yii::$app->user->id);
            $this->userSchoolRepository->save($userSchool);
        }
    }

    public function updateUserSchool($id, SchooLUserCreateForm $form, $class_id, $user_id): UserSchool
    {
        $usSchool = $this->userSchoolRepository->get($id, $user_id);
        $class = $this->classRepository->get($class_id);
        $school_id = $this->newOrRenameSchoolId($form, $this->schoolsRepository);

        $usSchool->edit($school_id, $class->id);
        return $usSchool;
    }

    public function newUserSchool(SchooLUserCreateForm $form, $class_id, $user_id): UserSchool
    {
        $class = $this->classRepository->get($class_id);
        $this->userSchoolRepository->isSchooLUser($user_id);
        $school_id = $this->newOrRenameSchoolId($form, $this->schoolsRepository);
        $userSchool = UserSchool::create($school_id, $user_id, $class->id);
        return $userSchool;
    }


    public function updateUserTeacherSchool($id, SchooLUserCreateForm $form, $user_id): UserTeacherJob
    {
        $teacherJob = $this->teacherSchoolRepository->get($id, $user_id);
        $school_id = $this->newOrRenameSchoolId($form, $this->schoolsRepository);
        $teacherJob->edit($school_id);
        $teacherJob->setStatus(UserTeacherJobHelper::DRAFT);
        $teacherJob->setHashNull();
        return $teacherJob;
    }

    public function newUserTeacherSchool(SchooLUserCreateForm $form, $user_id): UserTeacherJob
    {
        $school_id = $this->newOrRenameSchoolId($form, $this->schoolsRepository);
        $this->teacherSchoolRepository->isSchoolTeacher($user_id, $school_id);
        $this->userSchoolRepository->isSchooLUser($user_id);
        $teacherJob = UserTeacherJob::create($school_id, $user_id);

        return $teacherJob;
    }

    public function remove($id, $user_id, $role): void
    {
        if ($role == ProfileHelper::ROLE_TEACHER) {
            $teacher = $this->teacherSchoolRepository->get($id, $user_id);
            $this->teacherSchoolRepository->remove($teacher);
        }else {
            $usSchool = $this->userSchoolRepository->get($id, $user_id);
            if ($this->userOlimpiadsRepository->isOlympicUserYear($usSchool->edu_year, $user_id)) {
                throw new \DomainException("Вы не можете удалить школу, так как записаны на одну из олимпиад $usSchool->edu_year учебного года");
            }
            $this->userSchoolRepository->remove($usSchool);
        }
    }

    public function send($id, $user_id): void
    {
        $teacher = $this->teacherSchoolRepository->get($id, $user_id);
        $school = $this->schoolsRepository->get($teacher->school_id);
        if (is_null($school->email)) {
            throw new \DomainException('У данной школы нет электронной почты.');
        }
        try {
            $this->transactionManager->wrap(function () use ($teacher, $school) {
                $teacher->setStatus(UserTeacherJobHelper::WAIT);
                $teacher->generateVerificationToken();
                $configTemplate = ['html' => 'verifyTeacher-html', 'text' => 'verifyTeacher-text'];
                $configData = ['teacher' => $teacher];
                $this->sendTeacherEmail($school, $configTemplate, $configData);
                $this->teacherSchoolRepository->save($teacher);
            });
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error'," Ошибка сохранения");
        }
    }

    public function confirm($hash): void
    {
        $teacher = $this->teacherSchoolRepository->getHash($hash);
        $teacher->setStatus(UserTeacherJobHelper::ACTIVE);
        $this->teacherSchoolRepository->save($teacher);
    }
}