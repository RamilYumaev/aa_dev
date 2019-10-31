<?php
namespace common\tests\unit\dictionary\DictCountry;

use dictionary\models\Country;

class DictCountryValidateTest extends \Codeception\Test\Unit
{
    public function testValidateEmpty()
    {
        $model = new Country();
        $model->name = "";
        $model->cis = "";
        $model->far_abroad = "";
        $this->assertFalse($model->validate());

    }

    public function testValidateSuccessAllField()
    {
        $model = new Country();
        $model->name = "Узбекистан";
        $model->cis = true;
        $model->far_abroad = false;
        $this->assertTrue($model->validate());
    }

    public function testValidateSuccessOnlyName()
    {
        $model = new Country();
        $model->name = "Узбекистан";
        $model->cis = null;
        $model->far_abroad = null;
        $this->assertTrue($model->validate());
    }

    public function testValidateError()
    {
        $model = new Country();
        $model->name = "";
        $model->cis = true;
        $model->far_abroad = false;
        $this->assertFalse($model->validate());

    }
}