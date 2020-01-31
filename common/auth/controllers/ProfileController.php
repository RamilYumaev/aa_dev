<?php
namespace common\auth\controllers;

use common\auth\actions\ProfileAction;
use yii\web\Controller;

class ProfileController extends Controller
{

    public $view;

    public function actions()
    {
        return [
            'edit' => [
                'class' => ProfileAction::class,
                'view' => $this->view
            ],
        ];

    }

}