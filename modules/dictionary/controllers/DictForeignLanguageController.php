<?php


namespace modules\dictionary\controllers;

use modules\dictionary\forms\DictForeignLanguageForm;
use modules\dictionary\models\DictForeignLanguage;
use modules\dictionary\services\DictForeignLanguageService;
use modules\usecase\ControllerClass;


class DictForeignLanguageController extends ControllerClass
{

    public function __construct($id, $module,
                                DictForeignLanguageService $service,
                                DictForeignLanguage $model,
                                DictForeignLanguageForm $formModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
    }
}