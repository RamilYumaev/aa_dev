<?php

namespace olympic\forms\auth;

use olympic\forms\traits\SchoolUserTrait;
use yii\base\Model;

class SchooLUserForm extends  Model
{
    use SchoolUserTrait;

    public function __construct($role = null, $config = [])
    {
        $this->defaultDataCheck();
        $this->role = $role;
        parent::__construct($config);
    }
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return $this->rulesValidateRole($this->role, $this->selectorCreate);
    }
}