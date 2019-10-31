<?php
namespace common\tests\unit\dictionary\DictSpeciality;

use dictionary\forms\DictSpecialityCreateForm;
use dictionary\models\DictSpeciality;

class DictSpecialityValidateTest extends \Codeception\Test\Unit
{
    public function testValidateEmpty()
    {
        $model = new DictSpecialityCreateForm();
        $model->code = "";
        $model->name = "";
        $this->assertFalse($model->validate());
    }

    public function testValidateSuccess()
    {
        $model = new DictSpecialityCreateForm();
        $model->code = "44.03.01";
        $model->name = "Педагогическое образование";
        $this->assertTrue($model->validate());
    }

    public function testValidateErrorCode()
    {
        $model = new DictSpecialityCreateForm();
        $model->code = "";
        $model->name = "Педагогическое образование";
        $this->assertFalse($model->validate());
    }

    public function testValidateErrorName()
    {
        $model = new DictSpecialityCreateForm();
        $model->code = "44.03.01";
        $model->name = "";
        $this->assertFalse($model->validate());
    }
}