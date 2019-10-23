<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#form-signup';

    public function  _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
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
        $I->seeValidationError('Необходимо заполнить «Логин».');
        $I->seeValidationError('Необходимо заполнить «Почта (e-mail)».');
        $I->seeValidationError('Необходимо заполнить «Пароль».');
        $I->seeValidationError('Необходимо заполнить «Повторите пароль».');
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
                'SignupForm[verifyCode]'=>'testme',
                'SignupForm[agree]'=> true
        ]
        );
        $I->dontSee('Необходимо заполнить «Логин».', '.help-block');
        $I->dontSee('Необходимо заполнить «Пароль».', '.help-block');
        $I->see('Значение «Почта (e-mail)» не является правильным email адресом.', '.help-block');
        $I->see('Пароли не совпадают.', '.help-block');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'tester43',
            'SignupForm[email]' => 'tester34email@example.com',
            'SignupForm[password]' => 'some_password',
            'SignupForm[password_repeat]' => 'some_password',
            'SignupForm[verifyCode]'=>'testme',
            'SignupForm[agree]'=> true
        ]);

        $I->haveRecord('common\models\auth\User', [
            'id' => 7,
            'username' => 'test4.test',
            'auth_key' => '4XXdVqi3rDpa_a6JH6zqVreFxUPcUPvJ',
            //Test1234
            'password_hash' => '$2y$13$d17z0w/wKC4LFwtzBcmx6up4jErQuandJqhzKGKczfWuiEhLBtQBK',
            'email' => 'test4@mail.com',
            'status' => '0',
            'created_at' => '1548675330',
            'updated_at' => '1548675330',
            'verification_token' => 'already_used_token_1548675330',
        ]);


        $I->haveRecord('common\models\auth\AuthAssignment', [
            'item_name' => 'user',
            'user_id' => '7',
        ]);

        $I->seeEmailIsSent();

        $I->see('Спасибо за регистрацию. Пожалуйста, проверьте ваш почтовый ящик для проверки электронной почты.');
    }
}
