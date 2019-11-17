<?php


namespace olympic\services;


use common\auth\repositories\UserSchoolRepository;
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

    function __construct(UserOlimpiadsRepository $repository, OlimpicListRepository $olimpicListRepository,
                         ClassAndOlympicRepository $classAndOlympicRepository, UserSchoolRepository $userSchoolRepository)
    {
        $this->repository = $repository;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->classAndOlympicRepository = $classAndOlympicRepository;
        $this->userSchoolRepository = $userSchoolRepository;
    }

    public function add($olympic_id, $user_id) {
        $olympic = $this->olimpicListRepository->get($olympic_id);
        $userSchool = $this->userSchoolRepository->getSchooLUser($user_id);
        $this->classAndOlympicRepository->get($olympic->id, $userSchool->class_id);
        $userOlympic = UserOlimpiads::create($olympic->id, $userSchool->user_id);
        $this->repository->save($userOlympic);
    }

    public function remove($id) {
        $userOlympic = $this->repository->get($id);
        $this->repository->remove($userOlympic);
    }

}