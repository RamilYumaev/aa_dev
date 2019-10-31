<?php
namespace common\tests\unit\dictionary\DictSpecialTypeOlimpic;

use dictionary\forms\DictSpecialTypeOlimpicCreateForm;
use dictionary\models\DictSpecialTypeOlimpic;

class DictSpecialTypeOlimpicValidateTest extends \Codeception\Test\Unit
{
    public function testValidateEmpty()
    {
        $model = new DictSpecialTypeOlimpicCreateForm();
        $model->name = "";
        $this->assertFalse($model->validate());
    }

    public function testValidateSuccess()
    {
        $model = new DictSpecialTypeOlimpicCreateForm();
        $model->name = "Специальная олимпиада";
        $this->assertTrue($model->validate());
    }

}