<?php


namespace modules\dictionary\controllers;

use modules\dictionary\forms\DictCathedraForm;
use modules\dictionary\forms\DictForeignLanguageForm;
use modules\dictionary\models\DictCathedra;
use modules\dictionary\models\DictForeignLanguage;
use modules\dictionary\searches\DictCathedraSearch;
use modules\dictionary\services\DictCathedraService;
use modules\dictionary\services\DictForeignLanguageService;
use modules\usecase\ControllerClass;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class DictCathedraController extends ControllerClass
{

    public function __construct($id, $module,
                                DictCathedraService $service,
                                DictCathedra $model,
                                DictCathedraForm $formModel,
                                DictCathedraSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
        $this->searchModel = $searchModel;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev']
                    ]
                ],
            ],
        ];
    }
}