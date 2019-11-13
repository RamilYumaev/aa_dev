<?php
namespace frontend\widgets\olympic;

use olympic\readRepositories\UserOlympicReadRepository;
use olympic\models\OlimpicList;
use Yii;
use yii\base\Widget;

class UserOlympicWidget extends Widget
{
    /* @var $modelOlympicList OlimpicList */
    public $model;

    private $repository;

    public function __construct(UserOlympicReadRepository $repository, $config = [])
    {
        $this->repository = $repository;
        parent::__construct($config);
    }

    /**
     * @return
     */

    public function run()
    {
        $userOlympic = $this->repository->find($this->model->id, Yii::$app->user->id);
        return $this->render('user/index-user', [
            'userOlympic' => $userOlympic,
            'olympic' => $this->model
        ]);
    }
}