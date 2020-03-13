<?php


namespace dod\forms;

use common\auth\forms\CompositeForm;
use common\auth\forms\SignupForm;
use dod\models\DateDod;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\SchooLUserForm;

class SignupDodForm extends CompositeForm
{
    public $dateDodId;
    public $_dateDod;

    public function __construct(DateDod $dateDod, $config = [])
    {
        $this->dateDodId = $dateDod->id;
        $this->_dateDod = $dateDod;
        if($this->_dateDod->isTypeRemoteEdu()) {
            $this->schoolUser = new SchooLUserForm(null);
            $this->statusDodUser = new DodUserStatusForm();
        }
        if($this->_dateDod->isTypeIntramuralLiveBroadcast()) {
            $this->userTypeParticipation = new DodUserTypeParticipationForm();
        }
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
        $array = ['profile', 'user'];
        if($this->_dateDod->isTypeRemoteEdu()) {
            array_push($array, 'schoolUser', 'statusDodUser');
            return  $array;
        }
        if($this->_dateDod->isTypeIntramuralLiveBroadcast()) {
            array_push($array, 'userTypeParticipation');
            return  $array;
        }
        return $array;
    }
}