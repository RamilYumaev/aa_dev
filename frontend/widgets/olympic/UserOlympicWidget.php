<?php
namespace frontend\widgets\olympic;

use Yii;
use yii\base\Widget;

class UserOlympicWidget extends Widget
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
        $userDod = $this->repository->find($this->dod_id, Yii::$app->user->id);
        return $this->render('user/index-user', [
            'userDod' => $userDod,
            'dod_id' => $this->dod_id
        ]);
    }
}