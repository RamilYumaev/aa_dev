<?php

namespace common\user\widgets;
use common\auth\repositories\DeclinationFioRepository;
use yii\base\Widget;

class DeclinationWidget extends Widget
{
    private $repository;

    public function __construct(DeclinationFioRepository $repository, $config = [])
    {
        $this->repository = $repository;
        parent::__construct($config);
    }

    public function run()
    {
        $model = $this->repository->findByUser();
        if($model) {
            return $this->render('declination/index', [
                'model' => $model,
            ]);
        }
        return '';
    }

}
