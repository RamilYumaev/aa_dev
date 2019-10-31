<?php

namespace common\tests\unit\dictionary\DictSpecialization;

use dictionary\forms\DictSpecializationCreateForm;

class DictSpecializationValidateTest extends \Codeception\Test\Unit
{
    public function testValidateEmpty()
    {
        $model = new DictSpecializationCreateForm();
        $model->name = "";
        $model->speciality_id = "";
        $this->assertFalse($model->validate());
    }

    public function testValidateSuccess()
    {
        $model = new DictSpecializationCreateForm();
        $model->name = "Образовательная программа";
        $model->speciality_id = 1;
        $this->assertTrue($model->validate());
    }

    public function testValidateErrorName()
    {
        $model = new DictSpecializationCreateForm();
        $model->name = "";
        $model->speciality_id = 1;
        $this->assertFalse($model->validate());
    }

    public function testValidateErrorSpeciality()
    {
        $model = new DictSpecializationCreateForm();
        $model->name = "Образовательная программа";
        $model->speciality_id = "";
        $this->assertFalse($model->validate());
    }
}