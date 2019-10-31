<?php

namespace common\tests\unit\dictionary\DictDiscipline;

use dictionary\forms\DictDisciplineCreateForm;
use dictionary\models\DictDiscipline;

class DictDisciplineValidateTest extends \Codeception\Test\Unit
{
    public function testValidateEmpty()
    {
        $model = new DictDisciplineCreateForm();
        $model->name = "";
        $model->links = "";
        $this->assertFalse($model->validate());

    }

    public function testValidateSuccess()
    {
        $model = new DictDisciplineCreateForm();
        $model->name = "Русский язык";
        $model->links = "https://profteh.com/aspekt/student";
        $this->assertTrue($model->validate());
    }

}