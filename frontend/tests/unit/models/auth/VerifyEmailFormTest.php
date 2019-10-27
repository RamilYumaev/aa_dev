<?php

namespace frontend\tests\unit\models;

use common\auth\rbac\RoleManager;
use common\fixtures\UserFixture;
use common\auth\models\User;
use common\auth\repositories\UserRepository;
use common\auth\services\SignupService;
use common\transactions\TransactionManager;
use frontend\models\VerifyEmailForm;

class VerifyEmailFormTest extends \Codeception\Test\Unit
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

    private function serviceToken($token)
    {
        $repoUser = $this->make(UserRepository::class, ['find' => new User]);
        $transaction = $this->makeEmpty(TransactionManager::class);

        $serviceSignup = new SignupService($repoUser, $transaction);

        $serviceSignup->confirm($token);

    }

    public function testVerifyWrongToken()
    {
        $this->tester->expectException('yii\base\InvalidArgumentException', function () {
            $this->serviceToken('');
        });

        $this->tester->expectException(\DomainException::class, function () {
            $this->serviceToken('notexistingtoken_1391882543');
        });
    }

    public function testAlreadyActivatedToken()
    {
        $this->tester->expectException(\DomainException::class, function () {
            $this->serviceToken('already_used_token_1548675330');
        });
    }


    public function testVerifyCorrectToken()
    {
        $this->assertNull($this->serviceToken('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330'));
    }
}
