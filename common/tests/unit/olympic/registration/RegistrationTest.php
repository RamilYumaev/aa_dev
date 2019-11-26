<?php


use common\fixtures\dictionary\CategoryDocFixture;

class RegistrationTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'olympicList' => [
                'class' => \common\fixtures\olympic\OlympicListFixture::class,
                'dataFile' => codecept_data_dir() . 'olympic/olympic-list.php'
            ]
        ]);
    }

    public function testRegistration()
    {
        $olympicObject = $this->tester->grabFixture('olympicList', 0);
        $userRegistration = new \olympic\forms\SignupOlympicForm($olympicObject);
        $userRegistration->user = new \common\auth\forms\SignupForm();
    }


}