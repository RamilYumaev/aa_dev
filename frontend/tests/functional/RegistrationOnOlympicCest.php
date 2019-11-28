<?php


namespace frontend\tests\functional;

use common\fixtures\olympic\OlympicListFixture;
use common\helpers\FlashMessages;
use frontend\tests\FunctionalTester;

class RegistrationOnOlympicCest
{
    public function _fixtures()
    {
        return [
            "olympic" => [
                'class' => OlympicListFixture::class,
                'dataFile' => codecept_data_dir().'/olympic/olympic-list.php',
            ],
        ];
    }

    public function checkRegistration(FunctionalTester $I)
    {
        $I->amOnRoute("/olympiads");
        $I->see("Межрегиональный академический очный конкурс учебного наброска", "h4");
        $I->click("simplePlace dashedBlue");
        $I->see("Межрегиональный академический очный конкурс учебного наброска", "h1");
        $I->fillField("#signupform-username", "mark");
        $I->fillField("#signupform-email", "mark@mail.ru");
        $I->fillField("#signupform-password", "mark@mail.ru");
        $I->fillField("#signupform-password_repeat", "mark@mail.ru");
        $I->fillField("#profilecreateform-last_name", "Поддубный");
        $I->fillField("#profilecreateform-first_name", "Марк");
        $I->fillField("#profilecreateform-patronymic", "Николаевич");
        $I->fillField("#profilecreateform-phone", "+7(991)313-27-63");
        $I->fillField("#profilecreateform-country_id", 46);
        $I->fillField("#profilecreateform-region_id", 77);
        $I->fillField("#schooluserform-class_id", 7);
        $I->click('submit', '.btn-success');
        $I->see(FlashMessages::get()['successRegistration']);

    }

}