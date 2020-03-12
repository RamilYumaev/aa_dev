<?php
namespace frontend\widgets\dod;

use dod\readRepositories\DateDodReadRepository;
use Yii;
use dod\readRepositories\UserDodReadRepository;
use yii\base\Widget;

class UserDodWidget extends Widget
{
    public $dod_id;
    private $repository;
    private $dodRepository;

    public function __construct(UserDodReadRepository $repository,  DateDodReadRepository $dodRepository, $config = [])
    {
        $this->repository = $repository;
        $this->dodRepository = $dodRepository;
        parent::__construct($config);
    }

    /**
     * @return
     */

    public function run()
    {
        return !Yii::$app->user->isGuest ? $this->user() : $this->guest();
    }

    private function guest () {
        return $this->render('user/index-guest', [
            'dod' => $this->findOne($this->findOne($this->dod_id))
        ]);
    }

    private function findOne($id) {
        return $this->dodRepository->find($id);
    }

    private function user () {
        $userDod = $this->repository->find($this->dod_id, Yii::$app->user->id);
        return $this->render('user/index-user', [
            'userDod' => $userDod,
            'dod' => $this->findOne($this->findOne($this->dod_id))
        ]);
    }
}