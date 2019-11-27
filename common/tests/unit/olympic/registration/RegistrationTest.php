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

    public function testSignUpForm()
    {
        $userForm = new \common\auth\forms\SignupForm();
        $userForm->username = "ramil";
        $userForm->email = "ramilka06@inbox.ru";
        $userForm->password = "11111111";
        $userForm->password_repeat = "11111111";
        $userForm->agree = 1;

    }

    public function testRegistration()
    {
        $userForm = new \common\auth\forms\SignupForm();
        $userForm->username = "ramil";
        $userForm->email = "ramilka06@inbox.ru";
        $userForm->password = "11111111";
        $userForm->password_repeat = "11111111";
        $userForm->agree = 1;

        $profileForm = new \olympic\forms\auth\ProfileCreateForm();
        $profileForm->last_name = "Юмаев";
        $profileForm->first_name = "Рамиль";
        $profileForm->patronymic = "Анварович";
        $profileForm->phone = "+7(967)026-27-28";
        $profileForm->country_id = 46;
        $profileForm->region_id = 77;

        $userSchool = new \olympic\forms\auth\SchooLUserForm();
        $userSchool->school_id = 1;
        $userSchool->check_region_and_country_school = 1;
        $userSchool->country_school = 46;
        $userSchool->region_school = 77;
        $userSchool->class_id = 1;
        $userSchool->check_new_school = 1;
        $userSchool->new_school = NULL;
        $userSchool->check_rename_school = NULL;

        $olympicObject = $this->tester->grabFixture('olympicList', 0);
        $userRegistration = new \olympic\forms\SignupOlympicForm($olympicObject);
        $userRegistration->user = $userForm;
        $userRegistration->idOlympic = 1;
        $userRegistration->profile = $profileForm;
        $userRegistration->schoolUser = $userSchool;

        $model = new \olympic\services\OlympicRegisterUserService();


    }


}