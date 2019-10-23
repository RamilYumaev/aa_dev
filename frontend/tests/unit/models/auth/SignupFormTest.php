<?php
namespace frontend\tests\unit\models\auth;

use common\auth\rbac\RoleManager;
use common\fixtures\UserFixture;
use common\forms\auth\SignupForm;
use common\models\auth\User;
use common\repositories\UserRepository;
use common\services\auth\SignupService;
use common\transactions\TransactionManager;

class SignupFormTest extends \Codeception\Test\Unit
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

    public function testCorrectSignup()
    {
        $repoUser = $this->make(UserRepository::class,[ 'find' => new User] );
        $transaction = $this->makeEmpty(TransactionManager::class);

        $serviceSignup = new SignupService($repoUser, $transaction);
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password',
            'verifyCode'=>'testme',
            'agree'=> true
        ]);


        $user = $serviceSignup->NewUser($model);
        $serviceSignup->sendEmail($user);

        $this->assertNull($serviceSignup->signup($model));
        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        expect($mail)->isInstanceOf('yii\mail\MessageInterface');
        $this->assertArrayHasKey('some_email@example.com', $mail->getTo());
        $this->assertArrayHasKey(\Yii::$app->params['supportEmail'],  $mail->getFrom());
        $this->assertEquals($mail->getSubject(),'Аккуант зарегистрирован!' . \Yii::$app->name);
        expect($mail->toString())->stringContainsString($user->verification_token);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'test.test',
            'email' => 'test2@mail.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password',
            'verifyCode'=>'testme',
            'agree'=> true
        ]);
        $this->assertFalse($model->validate());
        $this->assertNotNull($model->getErrors('username'));
        $this->assertNotNull($model->getErrors('email'));

        $this->assertEquals('Этот логин уже существует.', $model->getFirstError('username'));
        $this->assertEquals('Этот адрес электронной почты уже существует.', $model->getFirstError('email'));
    }

    public function testNotCorrectPasswordRepeat()
    {
        $model = new SignupForm([
            'username' => 'troybeckerор',
            'email' => 'nicolas.dianna@hotmрail.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password33',
            'verifyCode'=>'testme',
            'agree'=> true
        ]);
        $this->assertFalse($model->validate());
        $this->assertNotNull($model->getErrors('password_repeat'));

        $this->assertEquals('Пароли не совпадают.', $model->getFirstError('password_repeat'));
    }

    public function testNotCorrectAgree()
    {
        $model = new SignupForm([
            'username' => 'troybeckerор',
            'email' => 'nicolas.dianna@hotmрail.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password',
            'verifyCode'=>'testme',
            'agree'=> false
        ]);
        $this->assertFalse($model->validate());
        $this->assertNotNull($model->getErrors('agree'));

        $this->assertEquals('Согласитесь, пожалуйста, с обработкой персональных данных, поставив соответствующую "галочку"', $model->getFirstError('agree'));
    }

}
