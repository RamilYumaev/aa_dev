<?php

namespace common\tests;

use common\fixtures\dictionary\DictClassFixture;


class beforeTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function dataFixture()
    {
        $this->tester->haveFixtures([
            'dictCLass' => [
                'class' => DictClassFixture::class,
                'dataFile' => codecept_data_dir() . 'dictionary/dict-class.php',
            ]
        ]);
    }

}