<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use yii\helpers\Url;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @return array
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @see \Codeception\Module\Yii2::_before()
     */

    private $formId = '#login-form';

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnPage('/auth/auth/login');
        $I->see('Вход');
    }

    public function testCreateInvalid(FunctionalTester $I)
    {
        $I->amOnRoute('/auth/auth/login');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('Необходимо заполнить «Логин или e-mail».');
        $I->seeValidationError('Необходимо заполнить «Пароль».');
    }


    public function testErrorPasswordLogin(FunctionalTester $I)
    {
        $I->amOnRoute('/auth/auth/login');
        $I->submitForm(
            $this->formId, [
                'LoginForm[username]' => '1213344',
                'LoginForm[password]' => 'u9398389498',
            ]
        );
        $I->see('Неверный логин или пароль. ');
    }


    public function testLogin(FunctionalTester $I)
    {
        $I->amOnRoute('/auth/auth/login');
        $I->submitForm($this->formId, [
            'LoginForm[username]' => 'erau',
            'LoginForm[password]' => 'password_0',
        ]);

        $I->see('Congratulations!', 'h1');
    }

    public function testLogOut(FunctionalTester $I)
    {
        $this->testLogin($I);
        $I->see("erau");
        $I->click("erau");
        $I->submitForm("#logout", []);
        $I->see("Вход");
    }

}
