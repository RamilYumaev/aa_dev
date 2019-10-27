<?php namespace backend\tests\functional\dictionary;

use backend\tests\FunctionalTester;
use common\fixtures\dictionary\CategoryDocFixture;
use dictionary\helpers\CategoryDocHelper;
use \dictionary\models\CategoryDoc;
use yii\helpers\Url;

class CategoryDocCest
{
    protected $formId = '#form-catDoc';

    public function _fixtures()
    {
        return [
            'catDoc' => [
                'class' => CategoryDocFixture::className(),
                'dataFile' => codecept_data_dir() . 'dictionary/category-doc.php'
            ]
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function testIndex(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/category-doc/index');
        $I->see('Категории документов', 'h1');
        $I->seeLink('Cоздать');
        $I->click('Cоздать');
        $I->see('Создать', 'h1');
    }

    public function testView(FunctionalTester $I)
    {
        $I->amOnPage(['dictionary/category-doc/view', 'id' => 1]);
        $I->see('Документ 1', 'h1');
    }

    public function testCreateInvalid(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/category-doc/create');
        $I->see('Создать', 'h1');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('Необходимо заполнить «Название категории».');
        $I->seeValidationError('Необходимо заполнить «Тип категории».');
    }

    public function testCorrectValidate(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/category-doc/create');
        $I->submitForm(
            $this->formId, [
                'CategoryDocForm[name]' => 'Документ 5',
                'CategoryDocForm[type_id]' => CategoryDocHelper::TYPEDOC,
            ]
        );
        $I->dontSee('Необходимо заполнить «Тип категории».', '.help-block');
        $I->dontSee('Необходимо заполнить «Название категории».', '.help-block');
    }

    public function testTypeIdIntegerErrorValidate(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/category-doc/create');
        $I->submitForm(
            $this->formId, [
                'CategoryDocForm[name]' => 'Документ 5',
                'CategoryDocForm[type_id]' => "словр"
            ]
        );
        $I->dontSee('Необходимо заполнить «Название категории».', '.help-block');
        $I->seeValidationError('Значение «Тип категории» должно быть целым числом.');
    }

    public function testTypeIdCategoryValidate(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/category-doc/create');
        $I->submitForm(
            $this->formId, [
                'CategoryDocForm[name]' => 'Документ 5',
                'CategoryDocForm[type_id]' => 75
            ]
        );
        $I->dontSee('Необходимо заполнить «Название категории».', '.help-block');
        $I->seeValidationError('Значение «Тип категории» неверно.');
    }


    public function testAdd(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/category-doc/create');
        $I->submitForm($this->formId, [
            'CategoryDocForm[name]' => 'Документ 5',
            'CategoryDocForm[type_id]' => CategoryDocHelper::TYPEDOC,
        ]);

        $I->seeRecord('\dictionary\models\CategoryDoc', [
            'name' => 'Документ 5',
            'type_id' => CategoryDocHelper::TYPEDOC,
        ]);
        $I->see('Документ 5', 'h1');
    }

    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage(['dictionary/category-doc/update', 'id' => 1]);
        $I->submitForm($this->formId, [
            'CategoryDocForm[name]' => 'Документ 6',
            'CategoryDocForm[type_id]' => CategoryDocHelper::TYPEDOC,
        ]);

        $I->seeRecord('\dictionary\models\CategoryDoc', [
            'name' => 'Документ 6',
            'type_id' => CategoryDocHelper::TYPEDOC,
        ]);
        $I->see('Документ 6', 'h1');
    }

    public function testDelete(FunctionalTester $I)
    {
        $I->amOnPage(['dictionary/category-doc/view', 'id' => 2]);
        $I->see('Линк 1', 'h1');
        $I->amGoingTo('Удалить');
        $I->sendAjaxPostRequest(Url::to(['dictionary/category-doc/view', 'id' => 2]));
        $I->expectTo('Are you sure you want to delete this item?');
        $I->dontSeeRecord('\dictionary\models\CategoryDoc', [
            'name' => 'Документ 6',
            'type_id' => CategoryDocHelper::TYPEDOC,
        ]);
    }
}