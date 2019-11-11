<?php


namespace olympic\services;


use olympic\models\UserOlimpiads;
use olympic\repositories\ClassAndOlympicRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\UserOlimpiadsRepository;

class UserOlimpiadsService
{
    private $repository;
    private $olimpicListRepository;
    private $classAndOlympicRepository;

    function __construct(UserOlimpiadsRepository $repository, OlimpicListRepository $olimpicListRepository,
                         ClassAndOlympicRepository $classAndOlympicRepository)
    {
        $this->repository = $repository;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->classAndOlympicRepository = $classAndOlympicRepository;
    }

    public function add($olympic_id, $user_id) {
        $olympic = $this->olimpicListRepository->get($olympic_id);
        $this->classAndOlympicRepository->get($olympic->id, '1'); //
        $userOlympic = UserOlimpiads::create($olympic->id, $user_id);
        $this->repository->save($userOlympic);
    }

    public function remove($olympic_id, $user_id) {
        $userOlympic = $this->repository->get($olympic_id, $user_id);
        $this->repository->remove($userOlympic);
    }

}