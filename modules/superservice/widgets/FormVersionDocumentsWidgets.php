<?php
namespace modules\superservice\widgets;

use modules\superservice\forms\DocumentsDynamicForm;
use yii\base\Widget;
use yii\widgets\ActiveForm;

class FormVersionDocumentsWidgets extends Widget
{
    /** @var array */
    public $oldData;

    /** @var ActiveForm */
    public $form;

    /** @var DocumentsDynamicForm */
    public $dynamicModel;

    public function run()
    {
        $model = $this->dynamicModel->createDynamicModel();
        if($this->oldData) {
            $model->setAttributes($this->oldData);
        }
       return $this->render('form', [
           'form'=> $this->form,
           'model' => $model,
           'fields' => $this->dynamicModel->getFields(),
           ]);
    }
}