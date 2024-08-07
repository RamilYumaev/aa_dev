<?php namespace common\tests\models\dictionary;


use Codeception\Test\Unit;
use common\fixtures\dictionary\CategoryDocFixture;
use dictionary\forms\CategoryDocForm;
use dictionary\helpers\CategoryDocHelper;
use dictionary\models\CategoryDoc;
use dictionary\repositories\CategoryDocRepository;
use dictionary\services\CategoryDocService;

class CategoryDocTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'catDoc' => [
                'class' => CategoryDocFixture::className(),
                'dataFile' => codecept_data_dir() . 'dictionary/category-doc.php'
            ]
        ]);
    }

    public function testValidationForm()
    {
        $model = new CategoryDocForm();

        $model->name = "";
        $model->type_id = null;
        $this->assertFalse($model->validate(['name']));
        $this->assertFalse($model->validate(['type_id']));

        $model->name = "Документ 2";
        $model->type_id = CategoryDocHelper::TYPEDOC;
        $this->assertTrue($model->validate(['name']));
        $this->assertTrue($model->validate(['type_id']));

        $model->name = "Документ 2";
        $model->type_id = "cлово";
        $this->assertTrue($model->validate(['name']));
        $this->assertFalse($model->validate(['type_id']));

        $model->name = "Документ 2";
        $model->type_id = 75;
        $this->assertTrue($model->validate(['name']));
        $this->assertFalse($model->validate(['type_id']));


    }

    public function testNewSaving()
    {
        $model = new CategoryDocForm();
        $model->name = "Документ 2";
        $model->type_id = CategoryDocHelper::TYPEDOC;

        $repoCat = $this->makeEmpty(CategoryDocRepository::class);

        $catDocModel = CategoryDoc::create($model);
        $this->returnSelf($catDocModel);

        $this->assertEquals($model->name, $catDocModel->name);
        $this->assertEquals($model->type_id, $catDocModel->type_id);

        $this->assertNull($repoCat->save($catDocModel));
    }

    public function testServiceSaving()
    {
        $repoCatDoc = $this->makeEmpty(CategoryDocRepository::class);
        $serviceCatDoc = new CategoryDocService($repoCatDoc);

        $model = new CategoryDocForm();
        $model->name = "Документ 3";
        $model->type_id = CategoryDocHelper::TYPEDOC;

        $catDocModel = $serviceCatDoc->create($model);
        $this->assertEquals($model->name, $catDocModel->name);
        $this->assertEquals($model->type_id, $catDocModel->type_id);
    }

    public function testServiceUpdate()
    {
        $repoCatDoc = $this->makeEmpty(CategoryDocRepository::class);
        $serviceCatDoc = new CategoryDocService($repoCatDoc);
        $this->assertIsObject($serviceCatDoc);

        $catDocOld = new CategoryDoc(["name" => "Линк 4", "type_id" => CategoryDocHelper::TYPELINK]);

        $model = new CategoryDocForm($catDocOld);
        $this->assertIsObject($model);

        $this->assertEquals($catDocOld->name, $model->name);
        $this->assertEquals($catDocOld->type_id, $model->type_id);

        $model->name = "Документ 3";
        $model->type_id = CategoryDocHelper::TYPEDOC;

        $this->assertEquals('Документ 3', $model->name);
        $this->assertEquals(CategoryDocHelper::TYPEDOC, $model->type_id);

        $catDocUpdate = $serviceCatDoc->edit(1, $model);

        $this->assertNull($catDocUpdate);
    }

    public function testServiceRemove()
    {
        $repoCatDoc = $this->makeEmpty(CategoryDocRepository::class);
        $serviceCatDoc = new CategoryDocService($repoCatDoc);
        $this->assertIsObject($serviceCatDoc);

        $facultyRemove = $serviceCatDoc->remove(1);
        $this->assertEmpty($facultyRemove);
    }
}