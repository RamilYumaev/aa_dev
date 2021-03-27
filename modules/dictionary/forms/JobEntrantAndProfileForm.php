<?php

namespace modules\dictionary\forms;
use common\auth\forms\CompositeForm;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use olympic\forms\auth\ProfileEditForm;

class JobEntrantAndProfileForm extends CompositeForm
{

    public $id_key;
    public function __construct(JobEntrant $entrant =null, $config = [])
    {
        $this->id_key = "kpokljgfedskkekljr";
        $this->profile = new ProfileEditForm();
        $this->jobEntrant = new JobEntrantForm($entrant);
        $this->jobEntrant->user_id =  $this->profile->user;
        $this->profile->country_id = $this->profile->country_id ?? 46;
        $this->profile->region_id =  $this->profile->region_id ?? 77;

        parent::__construct($config);
    }

    public function rules()
    {
        return [['id_key', 'string']];
    }

    protected function internalForms(): array
    {
        return ['profile', 'jobEntrant'];
    }
}