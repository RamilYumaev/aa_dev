<?php namespace common\tests;

use dictionary\forms\DictClassCreateForm;
use dictionary\helpers\DictClassHelper;
use common\fixtures\dictionary\DictClassFixture;


class dictClassValidate extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function dataFixture()
    {
        $this->tester->haveFixtures([
            'dictCLass' => [
                'class' => DictClassFixture::class,
                'dataFile' => codecept_data_dir() . 'dictionary/dict-class.php',
            ]
        ]);
    }


    protected function _after()
    {
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

    public function testWithFixture()
    {
        $this->tester->grabFixture('dictCLass');
    }
}