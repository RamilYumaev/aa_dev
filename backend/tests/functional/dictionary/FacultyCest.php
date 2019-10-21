<?php namespace backend\tests\functional\dictionary;
use backend\tests\FunctionalTester;
use common\fixtures\dictionary\FacultyFixture;
use yii\helpers\Url;

class FacultyCest
{
    protected $formId = '#form-faculty';

    public function  _fixtures()
    {
       return [
            'faculty' => [
                'class' => FacultyFixture::className(),
                'dataFile' => codecept_data_dir() . 'dictionary/faculty.php'
            ]
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function testIndex(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/faculty/index');
        $I->see('Факультеты', 'h1');
        $I->seeLink('Cоздать');
        $I->click('Cоздать');
        $I->see('Создать', 'h1');
    }

    public function testView(FunctionalTester $I)
    {
        $I->amOnPage(['dictionary/faculty/view', 'id' => 1]);
        $I->see('Дефектологический', 'h1');
    }

    public function  testCreateInvalid(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/faculty/create');
        $I->see('Создать', 'h1');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('Необходимо заполнить «Полное название».');
    }

    public function testUniqueError(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/faculty/create');
        $I->submitForm(
            $this->formId, [
                'FacultyForm[full_name]'  => 'Химический',
            ]
        );
        $I->dontSee('Необходимо заполнить «Полное название».', '.help-block');
        $I->see('Такое наименование существует', '.help-block');
    }

    public function testCorrectValidate(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/faculty/create');
        $I->submitForm(
            $this->formId, [
                'FacultyForm[full_name]'  => 'Психология',
            ]
        );
        $I->dontSee('Необходимо заполнить «Полное название».', '.help-block');
        $I->dontSee('Такое наименование существует', '.help-block');
    }

    public function testAdd(FunctionalTester $I)
    {
        $I->amOnRoute('dictionary/faculty/create');
        $I->submitForm($this->formId, [
            'FacultyForm[full_name]'  => 'Психологии'
        ]);

        $I->seeRecord('common\models\dictionary\Faculty', [
            'full_name' => 'Психологии'
        ]);
        $I->see('Психологии', 'h1');
    }

    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage(['dictionary/faculty/update', 'id' => 1]);
        $I->submitForm($this->formId, [
            'FacultyForm[full_name]'  => 'Дефектологический и и'
        ]);

        $I->seeRecord('common\models\dictionary\Faculty', [
            'full_name' => 'Дефектологический и и'
        ]);

        $I->see('Дефектологический и и', 'h1');
    }

    public function testDelete(FunctionalTester $I)
    {
        $I->amOnPage(['dictionary/faculty/view', 'id' => 3]);
        $I->see('Физический', 'h1');
        $I->amGoingTo('Удалить');
        $I->sendAjaxPostRequest(Url::to(['/dictionary/faculty/delete', 'id' => 3]));
        $I->expectTo('Are you sure you want to delete this item?');
        $I->dontSeeRecord('common\models\dictionary\Faculty', [
            'full_name' => 'Name For Deleting',
        ]);
    }
}