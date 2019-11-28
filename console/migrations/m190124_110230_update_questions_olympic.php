<?php

use \yii\db\Migration;
use \testing\services\QuestionConsoleService;

class m190124_110230_update_questions_olympic extends Migration
{
    private $service;
    public function __construct( QuestionConsoleService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }
    public function up()
    {

        $this->service->create();
    }

    public function down()
    {
        echo '';
    }
}
