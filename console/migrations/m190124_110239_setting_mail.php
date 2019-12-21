<?php

use yii\db\Migration;

class m190124_110239_setting_mail extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting_email}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'host' => $this->string(100)->notNull(),
            'username' => $this->string(100)->notNull(),
            'password' => $this->string(100)->notNull(),
            'port' => $this->string(5)->notNull(),
            'encryption' => $this->string(3)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%setting_email}}');
    }
}
