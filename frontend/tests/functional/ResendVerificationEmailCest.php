<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class ResendVerificationEmailCest
{
    protected $formId = '#request-password-reset-form';


    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @return array
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @see \Codeception\Module\Yii2::_before()
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/auth/reset/request');
    }

    protected function formParams($email)
    {
        return [
            'ResendVerificationEmailForm[email]' => $email
        ];
    }

    public function checkPage(FunctionalTester $I)
    {
        $I->see('Request password reset', 'h1');
        $I->see('Please fill out your email. A link to reset password will be sent there.');
    }

    public function checkEmptyField(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams(''));
        $I->seeValidationError('Необходимо заполнить «Email».');
    }

    public function checkWrongEmailFormat(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('abcd.com'));
        $I->seeValidationError('Необходимо заполнить «Email».');
    }

    public function checkWrongEmail(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('wrong@email.com'));
        $I->seeValidationError('Необходимо заполнить «Email».');
    }

    public function checkAlreadyVerifiedEmail(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('test2@mail.com'));
        $I->seeValidationError('Необходимо заполнить «Email».');
    }

    public function checkSendSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'PasswordResetRequestForm[email]' => 'test2@mail.com',
        ]);

        $I->canSeeEmailIsSent();

        $I->seeRecord('common\auth\models\User', [
            'email' => 'test2@mail.com',
            'username' => 'test2.test'
        ]);

        $I->see('Проверьте свою электронную почту для получения дальнейших инструкций.');
    }
}
