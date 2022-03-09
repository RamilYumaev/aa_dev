<?php

namespace modules\literature\forms;

use common\auth\forms\CompositeForm;
use dictionary\helpers\DictCountryHelper;
use modules\literature\models\LiteratureOlympic;
use modules\literature\models\PersonsLiterature;
use olympic\forms\auth\ProfileCreateForm;

/**
 * Signup form
 */
class RegisterGuestForm extends CompositeForm
{
    public $ids;
    private $isGuest;

    public function __construct($isGuest, $config = [])
    {   $this->ids = "dssd";
        $this->isGuest = $isGuest;
        if ($this->isGuest) {
            $this->user = new SignupForm();
            $this->profile  = new ProfileCreateForm(['country_id'=> DictCountryHelper::RUSSIA, 'region_id' => 1]);
        }
        $this->person = new PersonsLiterature();
        $this->olympic = new LiteratureOlympic();
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
        if($this->isGuest) {
            return ['user', 'profile', 'person', 'olympic'];
        }
        return ['person', 'olympic'];
    }
}