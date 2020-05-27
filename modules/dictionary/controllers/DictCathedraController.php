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
}