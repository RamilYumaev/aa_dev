<?php
namespace frontend\widgets\dod;

use Yii;
use dod\readRepositories\UserDodReadRepository;
use yii\base\Widget;

class UserDodWidget extends Widget
{
    public $dod_id;
    private $repository;

    public function __construct(UserDodReadRepository $repository, $config = [])
    {
        $this->repository = $repository;
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
            'dod_id' => $this->dod_id
        ]);
    }

    private function user () {
        $userDod = $this->repository->find($this->dod_id, Yii::$app->user->id);
        return $this->render('user/index-user', [
            'userDod' => $userDod,
            'dod_id' => $this->dod_id
        ]);
    }
}