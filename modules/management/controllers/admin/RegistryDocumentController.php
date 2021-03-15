<?php

namespace modules\management\controllers\admin;


use modules\management\searches\RegistryDocumentSearch;
use modules\management\services\RegistryDocumentService;
use modules\management\forms\RegistryDocumentForm;
use modules\management\models\RegistryDocument;
use modules\usecase\ControllerClass;

class RegistryDocumentController extends ControllerClass
{
    public function __construct($id, $module,
                                RegistryDocumentService $service,
                                RegistryDocumentForm $formModel,
                                RegistryDocument $model,
                                RegistryDocumentSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

}