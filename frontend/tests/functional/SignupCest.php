<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#form-signup';

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('auth/signup/request');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('Регистрация', 'h2');
        $I->see('заполните форму');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('Необходимо заполнить «Придумайте логин для личного кабинета (это может быть ваш email)».');
        $I->seeValidationError('Необходимо заполнить «Адрес электронной почты:».');
        $I->seeValidationError('Необходимо заполнить «Придумайте пароль».');
        $I->seeValidationError('Необходимо заполнить «Повтор пароля».');
        $I->seeValidationError('Согласитесь, пожалуйста, с обработкой персональных данных, поставив соответствующую "галочку"');
        $I->seeValidationError('Неправильный проверочный код.');

    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
                'SignupForm[username]' => 'troybeckerор',
                'SignupForm[email]' => 'nicolas.dianna@hotmрail.com',
                'SignupForm[password]' => 'some_password',
                'SignupForm[password_repeat]' => 'some_password33',
                'SignupForm[verifyCode]' => 'testme',
                'SignupForm[agree]' => true
            ]
        );
        $I->dontSee('Необходимо заполнить «Логин».', '.help-block');
        $I->dontSee('Необходимо заполнить «Пароль».', '.help-block');
        $I->see('Значение «Адрес электронной почты:» не является правильным email адресом.', '.help-block');
        $I->see('Пароли не совпадают.', '.help-block');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'tester43',
            'SignupForm[email]' => 'tester34email@example.com',
            'SignupForm[password]' => 'some_password',
            'SignupForm[password_repeat]' => 'some_password',
            'SignupForm[verifyCode]' => 'testme',
            'SignupForm[agree]' => true
        ]);


        $I->seeRecord('common\auth\models\User', [
            'username' => 'tester43',
            'email' => 'tester34email@example.com',
            'status' => '0',
        ]);

        $I->seeEmailIsSent();


        $I->see('Спасибо за регистрацию. Пожалуйста, проверьте ваш почтовый ящик для проверки электронной почты.');
    }
}
