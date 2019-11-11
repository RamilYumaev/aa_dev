<?php


namespace dod\forms;

use common\auth\forms\CompositeForm;
use common\auth\forms\SignupForm;
use dod\models\DateDod;
use olympic\forms\auth\ProfileCreateForm;

class SignupDodForm extends CompositeForm
{
    public $dateDodId;
    public function __construct(DateDod $dateDod, $config = [])
    {
        $this->dateDodId = $dateDod->id;
        $this->user = new SignupForm();
        $this->profile = new ProfileCreateForm();
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
          ['dateDodId', 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['profile', 'user'];
    }
}