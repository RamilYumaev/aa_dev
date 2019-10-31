<?php namespace common\tests;

use dictionary\forms\DictClassCreateForm;
use dictionary\helpers\DictClassHelper;


class dictClassValidateTest extends \Codeception\Test\Unit
{


    // tests
    public function testValidateEmptyNameForm()
    {
        $model = new DictClassCreateForm();
        $model->name = "";
        $model->type = DictClassHelper::SCHOOL;
        $this->assertFalse($model->validate());

    }

    public function testValidateEmptyTypeForm()
    {
        $model = new DictClassCreateForm();
        $model->name = 1;
        $model->type = "";
        $this->assertFalse($model->validate());

    }
}