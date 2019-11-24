<?php


namespace olympic\forms;

use common\auth\forms\CompositeForm;
use common\auth\forms\SignupForm;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\SchooLUserForm;
use olympic\helpers\ClassAndOlympicHelper;
use olympic\models\Olympic;

class SignupOlympicForm extends CompositeForm
{
    private $_olympic;
    public $idOlympic;

    public function __construct(Olympic $olympic, $config = [])
    {
        $this->_olympic = $olympic;
        $this->user = new SignupForm();
        $this->idOlympic =  $this->_olympic->olympicOneLast->id;
        $this->profile = new ProfileCreateForm();
        $this->schoolUser = new SchooLUserForm();
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
          ['idOlympic', 'required'],
        ];
    }

    public function classFullNameList(): array
    {
        return ClassAndOlympicHelper::olympicClassLists($this->_olympic->olympicOneLast->id);
    }

    protected function internalForms(): array
    {
        return ['profile', 'user', 'schoolUser'];
    }
}