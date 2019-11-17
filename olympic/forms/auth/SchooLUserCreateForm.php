<?php


namespace olympic\forms\auth;

use common\auth\forms\CompositeForm;
use common\auth\models\UserSchool;
use olympic\repositories\auth\ProfileRepository;

class SchooLUserCreateForm extends CompositeForm
{
    public $_profile;
    public $region_id;
    public $country_id;

    public function __construct(UserSchool $userSchool = null, $config = [])
    {
        $repository = new ProfileRepository();
        $this->_profile = $repository->getUserId();
        if($this->_profile) {
            $this->region_id = $this->_profile->region_id ?? 0;
            $this->country_id = $this->_profile->country_id;
        }
        if ($userSchool) {
            $this->schoolUser = new SchoolUserUpdateForm($userSchool);
        } else {
            $this->schoolUser = new SchooLUserForm();
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['region_id', 'country_id'], 'required'],
        ];
    }

    protected function internalForms(): array
    {
       return ['schoolUser'];
    }
}