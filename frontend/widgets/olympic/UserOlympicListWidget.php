<?php
namespace frontend\widgets\olympic;

use olympic\readRepositories\UserOlympicReadRepository;
use olympic\models\OlimpicList;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class UserOlympicListWidget extends Widget
{
    private $repository;

    public $view = 'olympic-list-user/index';

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
        $query = $this->repository->findAll(Yii::$app->user->id);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}