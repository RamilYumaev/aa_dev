<?php

namespace common\tests\unit\dictionary\DictChairmans;

use dictionary\forms\DictChairmansCreateForm;
use dictionary\models\DictChairmans;
use yii\web\UploadedFile;

class DictChairmansValidateTest extends \Codeception\Test\Unit
{
    public function newFile()
    {
        $photo = new UploadedFile();
        $photo->name = "1.jpg";
        $photo->tempName = __DIR__ . "../../../_data/1.jpg";
        $photo->type = "image/jpg";
        $photo->size = 1024 * 1024;
        return $photo;

    }

    public function testValidateEmpty()
    {
        $model = new DictChairmansCreateForm();
        $model->last_name = "";
        $model->first_name = "";
        $model->patronymic = "";
        $model->position = "";
        $this->assertFalse($model->validate()); //@TODO

    }

    public function testValidateSuccess()
    {
        $model = new DictChairmansCreateForm();
        $model->last_name = "Харитонова";
        $model->first_name = "Ирина";
        $model->patronymic = "Викторовна";
        $model->position = "Зав. кафедры";
        $model->photo =$this->newFile();
        $this->assertTrue($model->validate());


    }

    public function testValidateErrorLastName()
    {
        $model = new DictChairmansCreateForm();
        $model->last_name = "";
        $model->first_name = "Ирина";
        $model->patronymic = "Викторовна";
        $model->position = "Зав. кафедры";
        $model->photo = $this->newFile();
        $this->assertFalse($model->validate()); //@TODO
    }
}