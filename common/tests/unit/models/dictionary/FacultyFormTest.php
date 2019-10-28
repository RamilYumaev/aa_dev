<?php namespace common\tests\models\dictionary;

use common\fixtures\dictionary\FacultyFixture;
use dictionary\forms\FacultyCreateForm;
use dictionary\forms\FacultyEditForm;
use dictionary\models\Faculty;
use dictionary\repositories\FacultyRepository;
use dictionary\services\FacultyService;

class FacultyFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'faculty' => [
                'class' => FacultyFixture::className(),
                'dataFile' => codecept_data_dir() . 'dictionary/faculty.php'
            ]
        ]);
    }

    public function testValidationForm()
    {
        $model = new FacultyCreateForm();

        $model->full_name = "";
        $this->assertFalse($model->validate(['full_name']));

        $model->full_name = "Suka";
        $this->assertTrue($model->validate(['full_name']));

    }

    public function testValidationFormUnique()
    {
        $form = new FacultyCreateForm();
        $form->full_name = "Xegggg";
        $this->assertFalse($form->validate());
        $this->assertEquals('Такое наименование существует', $form->getFirstError('full_name'));
    }

    public function testNewSavingFaculty()
    {
        $form = new FacultyCreateForm();
        $form->full_name = "Suka";

        $repoFaculty = $this->makeEmpty(FacultyRepository::class);

        $facultyModel = Faculty::create($form);
        $this->returnSelf($facultyModel);

        $this->assertEquals('Suka', $facultyModel->full_name);
        $this->assertNull($repoFaculty->save($facultyModel));
    }

    public function testServiceSavingFaculty()
    {
        $repoFaculty = $this->makeEmpty(FacultyRepository::class);
        $serviceFaculty = new FacultyService($repoFaculty);

        $form = new FacultyCreateForm();
        $form->full_name = "Suka";

        $facultyModel = $serviceFaculty->create($form);
        $this->assertEquals('Suka', $facultyModel->full_name);
    }

    public function testServiceUpdateFaculty()
    {
        $repoFaculty = $this->makeEmpty(FacultyRepository::class);
        $serviceFaculty = new FacultyService($repoFaculty);
        $this->assertIsObject($serviceFaculty);

        $form = new FacultyEditForm(new Faculty(["full_name" => "Suka"]));
        $this->assertIsObject($form);
        $this->assertEquals('Suka', $form->full_name);

        $form->full_name = "Suka Update";
        $this->assertEquals('Suka Update', $form->full_name);

        $facultyUpdate = $serviceFaculty->edit($form);

        $this->assertNull($facultyUpdate);
    }

    public function testServiceRemoveFaculty()
    {
        $repoFaculty = $this->makeEmpty(FacultyRepository::class);

        $serviceFaculty = new FacultyService($repoFaculty);
        $this->assertIsObject($serviceFaculty);

        $facultyRemove = $serviceFaculty->remove(1);
        $this->assertEmpty($facultyRemove);
    }
}