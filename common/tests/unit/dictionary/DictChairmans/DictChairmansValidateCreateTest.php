<?php

namespace common\tests\unit\dictionary\DictChairmans;

use common\fixtures\dictionary\DictChairmansFixture;
use dictionary\forms\DictChairmansCreateForm;
use dictionary\models\DictChairmans;
use yii\web\UploadedFile;

class DictChairmansValidateCreateTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'dict_chairmans' => [
                'class' => DictChairmansFixture::class,
                'dataFile' => codecept_data_dir() . 'dictionary/dict-chairmans.php',
            ],
        ]);
    }

    public function newFile($fileName)
    {
        $photo = new UploadedFile();
        $photo->name = $fileName;
        //$photo->tempName = __DIR__ . "../../../_data/1.jpg";
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
        $model->last_name = "Чернышева";
        $model->first_name = "Елена";
        $model->patronymic = "Геннадьевна";
        $model->position = "Директор Института филологии, доцент, доктор филологических наук";
        $model->photo = $this->newFile("3.jpg");
        $this->assertTrue($model->validate());


    }

    public function testUnique()
    {

        $result = "Комбинация \"Харитонова\"-\"Ирина\"-\"Викторовна\"-\"Заведующая кафедрой романских";
        $result .= " языков им. В. Г. Гака Института иностранных языков\" параметров Фамилия, Имя, ";
        $result .= "Отчество и Должность уже существует.";

        $model = new DictChairmansCreateForm();
        $model->last_name = "Харитонова";
        $model->first_name = "Ирина";
        $model->patronymic = "Викторовна";
        $model->position = "Заведующая кафедрой романских языков им. В. Г. Гака Института иностранных языков";
        $model->photo = $this->newFile("1.jpg");
        $this->assertFalse($model->validate());
        $this->assertEquals($result, $model->getFirstError('last_name'));
    }

    public function testValidateErrorLastName()
    {
        $model = new DictChairmansCreateForm();
        $model->last_name = "";
        $model->first_name = "Александра";
        $model->patronymic = "Викторовна";
        $model->position = "Зав. кафедры";
        $model->photo = $this->newFile("3.jpg");
        $this->assertFalse($model->validate()); //@TODO
    }
}