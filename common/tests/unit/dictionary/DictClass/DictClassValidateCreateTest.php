<?php namespace common\tests;

use common\fixtures\dictionary\DictClassFixture;
use dictionary\forms\DictClassCreateForm;
use dictionary\helpers\DictClassHelper;


class DictClassValidateCreateTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'dict_class' => [
                'class' => DictClassFixture::class,
                'dataFile' => codecept_data_dir() . "dictionary/dict-class.php",
            ],
        ]);
    }

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

    public function testValidateUnique()
    {
        $model = new DictClassCreateForm();
        $model->name = "1";
        $model->type = "2";
        $this->assertFalse($model->validate());
        $this->assertEquals("Комбинация \"1\"-\"2\" параметров Номер и Тип уже существует.",
            $model->getFirstError("name"));
    }
}