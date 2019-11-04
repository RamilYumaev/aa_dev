<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use Yii;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see(Yii::$app->name);
        $I->seeLink('Олимпиады/конкурсы');
        $I->click('Олимпиады/конкурсы');
        $I->see('Олимпиады/конкурсы');
    }
}