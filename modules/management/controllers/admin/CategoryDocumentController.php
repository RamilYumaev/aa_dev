<?php

namespace modules\management\controllers\admin;


use modules\management\searches\CategoryDocumentSearch;
use modules\management\services\CategoryDocumentService;
use modules\management\forms\CategoryDocumentForm;
use modules\management\models\CategoryDocument;
use modules\usecase\ControllerClass;

class CategoryDocumentController extends ControllerClass
{
    public function __construct($id, $module,
                                CategoryDocumentService $service,
                                CategoryDocumentForm $formModel,
                                CategoryDocument $model,
                                CategoryDocumentSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

}