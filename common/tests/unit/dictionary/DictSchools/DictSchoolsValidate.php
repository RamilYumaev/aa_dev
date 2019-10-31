<?php

namespace common\tests\unit\dictionary\DictSchools;

use Codeception\Test\Unit;
use common\fixtures\dictionary\DictSchoolsFixture;
use dictionary\forms\DictSchoolsCreateForm;
use dictionary\models\DictSchools;

class DictSchoolsValidate extends Unit
{

    /**
     * @var \common\tests\UnitTester
     */

    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'dictSchool' => [
                'class' => DictSchoolsFixture::class,
                'dataFile' => codecept_data_dir() . 'dictionary/dict-schools.php'
            ],
        ]);
    }

    public function testValidateEmpty()
    {
        $model = new DictSchoolsCreateForm();
        $model->name = "";
        $model->country_id = "";
        $model->region_id = "";
        $this->assertFalse($model->validate());
    }

    public function testValidateSuccess()
    {
        $model = new DictSchoolsCreateForm();
        $model->name = "ФГБОУ ВО МПГУ";
        $model->country_id = 46;
        $model->region_id = 1;
        $this->assertTrue($model->validate());
    }

    public function testValidateErrorName()
    {
        $model = new DictSchoolsCreateForm();
        $model->name = "";
        $model->country_id = 46;
        $model->region_id = "";
        $this->assertTrue($model->validate());
    }

    public function testValidateErrorCountry()
    {
        $model = new DictSchoolsCreateForm();
        $model->name = "МПГУ";
        $model->country_id = "";
        $model->region_id = "";
        $this->assertTrue($model->validate());
    }
}