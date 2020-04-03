<?php

namespace modules\entrant\controllers;


use modules\dictionary\models\DictIndividualAchievement;
use yii\base\Controller;
use yii\filters\VerbFilter;

class IndividualAchievementsController extends Controller
{
    private $service;

    public function __construct($id, $module, DictIndividualAchievement $service, $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = DictIndividualAchievement::getFilteredByUserIndividualAchievement();

        return $this->render("index", ["model" => $model]);
    }

}