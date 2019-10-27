<?php

namespace frontend\tests\unit\models;

use common\auth\repositories\UserRepository;
use common\auth\services\PasswordResetService;
use common\transactions\TransactionManager;
use common\auth\forms\PasswordResetRequestForm;
use common\fixtures\UserFixture as UserFixture;
use common\auth\models\User;

class PasswordResetRequestFormTest extends \Codeception\Test\Unit
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
            ]
        ]);
    }

    private function serviceReset()
    {
        $repoUser = $this->make(UserRepository::class, ['find' => new \common\auth\models\User]);
        $transaction = $this->makeEmpty(TransactionManager::class);
        $resetService = new PasswordResetService($repoUser, $transaction);
        return $resetService;
    }

    public function testSendMessageWithWrongEmailAddress()
    {
        $model = new PasswordResetRequestForm();
        $model->email = 'not-existing-email@example.com';

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage($this->serviceReset()->requestPassword($model));
    }

    public function testNotSendEmailsToInactiveUser()
    {
        $user = $this->tester->grabFixture('user', 0);
        $model = new PasswordResetRequestForm();
        $model->email = $user['email'];
        $this->assertFalse($model->validate());
        $this->assertEquals("Нет пользователя с этим адресом электронной почты.", $model->getFirstError("email"));
    }

    public function testSendEmailSuccessfully()
    {
        $userFixture = $this->tester->grabFixture('user', 2);
        $model = new PasswordResetRequestForm();
        $model->email = $userFixture['email'];

        $user = $this->serviceReset()->requestPassword($model);
        $this->serviceReset()->sendEmail($user);
        $this->assertNull($this->serviceReset()->request($model));

        expect_that($user->password_reset_token);

        $emailMessage = $this->tester->grabLastSentEmail();

        expect($emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        $this->assertArrayHasKey($model->email, $emailMessage->getTo());
        $this->assertArrayHasKey(\Yii::$app->params['supportEmail'], $emailMessage->getFrom());
        $this->assertEquals($emailMessage->getSubject(), 'Сброс пароля ' . \Yii::$app->name);
    }
}
