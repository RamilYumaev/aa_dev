<?php


namespace olympic\forms\auth;

use olympic\forms\traits\SchoolUserTrait;
use yii\base\Model;

class SchoolUserUpdateForm extends  Model
{
    use SchoolUserTrait;

    public function __construct($userSchool, $role = null, $config = [])
    {
        $this->role = $role;
        $this->defaultUpdateData($userSchool);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return $this->rulesValidateRole($this->role, $this->selectorUpdate);
    }
    
}