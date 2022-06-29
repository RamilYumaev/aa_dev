<?php

namespace modules\entrant\behaviors;

use modules\superservice\forms\DocumentsDynamicForm;
use yii\base\Behavior;
use yii\base\Model;

class EpguBehavior extends Behavior
{
    /**
     * @var DocumentsDynamicForm
     */
    public $dynamicModel;
    /**
     * @var Model
     */
    public $owner;

    public function events()
    {
        return [
            Model::EVENT_AFTER_VALIDATE => 'afterValidate',
        ];
    }

    public function afterValidate($event) {
        if($this->dynamicModel &&  $formModel = $this->dynamicModel->createDynamicModel())
        {
            if($formModel->load(\Yii::$app->request->post())) {
                $this->owner->other_data = $formModel->getAttributes();
            }
        }else {
            $this->owner->other_data = null;
        }
    }
}