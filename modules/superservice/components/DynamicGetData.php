<?php
namespace modules\superservice\components;


use modules\superservice\forms\DocumentsDynamicForm;

class DynamicGetData
{
    private $oldData;

    public function dynamicForm($version = null) {
        if($version = (\Yii::$app->request->get('version') ?? $version)){
            $dynamic = new DocumentsDynamicForm($version);
            if($dynamic->getFields()) {
                return $dynamic;
            }
        }
        return null;
    }

    public function loadData(DocumentsDynamicForm $documentsDynamicForm = null) {
        if($documentsDynamicForm &&  $formModel = $documentsDynamicForm->createDynamicModel())
        {
            if($formModel->load(\Yii::$app->request->post())) {
                return $formModel;
            }
        }
        return null;
    }
}
