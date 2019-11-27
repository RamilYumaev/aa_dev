<?php

use \yii\db\Migration;

class m190124_110225_after_column_type_table_question_proposition extends Migration
{
    public function up()
    {
        $this->alterColumn('{{question_proposition}}', 'type', $this->integer(1)->null());
    }

    public function down()
    {
        $this->alterColumn('{{question_proposition}}', 'type', $this->integer(1)->notNull());
    }
}
