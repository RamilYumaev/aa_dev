<?php


namespace dod\forms;

use common\auth\forms\CompositeForm;
use dod\models\DateDod;
use olympic\forms\auth\SchooLUserCreateForm;

class SignUpDodRemoteUserForm extends CompositeForm
{
    public $dateDodId;
    public $_dateDod;

    public function __construct(DateDod $dateDod, $config = [])
    {
        $this->dateDodId = $dateDod->id;
        $this->_dateDod = $dateDod;
        $this->schoolUser = new SchooLUserCreateForm(null);
        $this->statusDodUser = new DodUserStatusForm();

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
        return  ['schoolUser', 'statusDodUser'];

    }
}