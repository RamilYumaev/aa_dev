<?php

use \yii\db\Migration;
use \testing\services\AnswersService;

class m190124_110229_after_columns_answer_match_and_name_in_table_answer extends Migration
{
    private $service;
    public function __construct( AnswersService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }
    public function up()
    {
        $this->alterColumn('answer', 'answer_match', $this->text());
        $this->alterColumn('answer', 'name', $this->text());

        $this->service->create();
    }

    public function down()
    {
        $this->alterColumn('answer', 'answer_match', $this->string()->null());
        $this->alterColumn('answer', 'name', $this->string()->null());
    }
}
