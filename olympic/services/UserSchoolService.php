<?php


namespace olympic\services;

use common\auth\models\UserSchool;
use dictionary\repositories\DictClassRepository;
use dictionary\repositories\DictSchoolsRepository;
use olympic\forms\auth\SchooLUserCreateForm;
use common\auth\repositories\UserSchoolRepository;
use dictionary\models\DictSchools;



class UserSchoolService
{
    private $userSchoolRepository;
    private $classRepository;
    public $schoolsRepository;

    public function __construct(
        UserSchoolRepository $userSchoolRepository,
        DictClassRepository $classRepository,
        DictSchoolsRepository $schoolsRepository
    )
    {
        $this->userSchoolRepository = $userSchoolRepository;
        $this->schoolsRepository = $schoolsRepository;
        $this->classRepository = $classRepository;
    }

    public function signup(SchooLUserCreateForm $form): void
    {

        $userSchool = $this->newUserSchool($this->newOrRenameSchoolId($form), $form->schoolUser->class_id, \Yii::$app->user->id);
        $this->userSchoolRepository->save($userSchool);

    }

    public function newUserSchool($school_id, $class_id, $user_id): UserSchool
    {
        $class = $this->classRepository->get($class_id);
        $this->userSchoolRepository->isSchooLUser($user_id);
        $userSchool = UserSchool::create($school_id, $user_id, $class->id);
        return $userSchool;
    }

     public  function newOrRenameSchoolId(SchooLUserCreateForm $form) : int
     {
         $userSchoolForm =  $form->schoolUser;

         if($userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_new_school &&
             $userSchoolForm->new_school) {
             $this->schoolsRepository->getFull($userSchoolForm->new_school,  $form->country_id, $form->region_id);
             $school = DictSchools::create($userSchoolForm->new_school,  $form->country_id, $form->region_id);
         } elseif (!$userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_new_school &&
             $userSchoolForm->new_school) {
             $this->schoolsRepository->getFull($userSchoolForm->new_school, $userSchoolForm->country_school, $userSchoolForm->region_school);
             $school = DictSchools::create($userSchoolForm->new_school,  $userSchoolForm->country_school, $userSchoolForm->region_school);
         } elseif ($userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_rename_school &&
             $userSchoolForm->new_school) {
             $school = $this->schoolsRepository->get($userSchoolForm->school_id);
             $school->edit($userSchoolForm->new_school, $form->country_id, $form->region_id);
         } elseif (!$userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_rename_school &&
             $userSchoolForm->new_school) {
             $school = $this->schoolsRepository->get($userSchoolForm->school_id);
             $school->edit($userSchoolForm->new_school, $userSchoolForm->country_school, $userSchoolForm->region_school);
         } else {
             $school = $this->schoolsRepository->get($userSchoolForm->school_id);
         }
         $this->schoolsRepository->save($school);
         return $school->id;
     }

    public function remover($school_id, $class_id, $user_id): void
    {
        $class = $this->classRepository->get($class_id);
        $this->userSchoolRepository->isSchooLUser($user_id);
        $userSchool = UserSchool::create($school_id, $user_id, $class->id);
    }
}