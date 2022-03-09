<?php

namespace modules\literature\forms;

use common\auth\forms\CompositeForm;
use common\auth\models\User;
use dictionary\helpers\DictCountryHelper;
use modules\literature\models\LiteratureOlympic;
use modules\literature\models\PersonsLiterature;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\ProfileEditForm;

/**
 * Signup form
 */
class RegisterForm extends CompositeForm
{
    public $ids;
    public $ifUser;

    public function __construct(User $user = null, $config = [])
    {
        $this->ids = "dssd";
        if (!$user) {
            $this->ifUser = false;
            $this->user = new SignupForm();
            $this->user->setScenario(SignupForm::REGISTER);
            $this->profile  = new ProfileCreateForm(['country_id'=> DictCountryHelper::RUSSIA]);
        }else {
            $this->ifUser = true;
            $this->user = new SignupForm($user);
            $this->user->setScenario(SignupForm::UPDATE);
            $this->profile  = new ProfileEditForm(['country_id'=> DictCountryHelper::RUSSIA]);
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['ids', 'required'],
        ];
    }


    protected function internalForms(): array
    {
        return ['user', 'profile'];
    }
}