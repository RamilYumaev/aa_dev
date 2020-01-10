<?php

use \yii\db\Migration;

class  m190124_110250_add_table_web_conference extends Migration
{
    public function up()
    {
        $this->createTable('{{web_conference}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->null(),
            'link' => $this->string()->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%web_conference}');
    }
}
