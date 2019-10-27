<?php

namespace common\tests\unit\models;

use common\auth\models\User;
use common\auth\repositories\UserRepository;
use olympic\services\auth\AuthService;
use Yii;
use olympic\forms\auth\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        $this->assertTrue($model->validate());
        expect('Вы не можете войти в систему', Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $repoUser = $this->make(UserRepository::class, ['find' => new User]);
        $serviceAuth = new AuthService($repoUser);
        $model = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'wrong_password',
        ]);


        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage($serviceAuth->auth($model));
    }

    public function testLoginCorrect()
    {
        $repoUser = $this->make(UserRepository::class, ['find' => new User]);
        $serviceAuth = new AuthService($repoUser);

        $model = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]);

        $user = $serviceAuth->auth($model);

        expect('Вы вошли в систему', !Yii::$app->user->isGuest)->false();
        $this->assertTrue($model->validate());
        $this->assertIsObject($user);
        $this->assertEquals($model->username, $user->username);
    }
}
