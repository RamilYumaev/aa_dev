<?php

namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use common\forms\auth\ResetPasswordForm;
use common\repositories\UserRepository;
use common\services\auth\PasswordResetService;
use common\transactions\TransactionManager;

class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    private function servicePasswordReset($token, resetPasswordForm $form)
    {
        $repoUser = $this->make(UserRepository::class, ['find' => new \common\models\auth\User]);
        $transaction = $this->makeEmpty(TransactionManager::class);

        $resetService = new PasswordResetService($repoUser, $transaction);
        $resetService->reset($token, $form);
    }

    public function testResetWrongToken()
    {
        $this->tester->expectException(\DomainException::class, function () {
            $this->servicePasswordReset("", new ResetPasswordForm(['password' => "1234567"]));
        });

        $this->tester->expectException(\DomainException::class, function () {
            $this->servicePasswordReset("notexistingtoken_1391882543", new ResetPasswordForm(['password' => "1234567"]));
        });
    }

    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 1);
        $form = new ResetPasswordForm(['password' => "1234567"]);
        $this->assertTrue($form->validate());
        $this->assertNull($this->servicePasswordReset($user['password_reset_token'], $form));

    }

}
