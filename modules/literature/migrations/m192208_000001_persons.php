<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000001_persons extends Migration
{
    private function table() {
        return 'persons_literature';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
            'sex' => $this->smallInteger(1),
            'birthday' => $this->date()->notNull(),
            'place_birth' => $this->string()->notNull(),
            'phone'=> $this->string()->notNull(),
            'email' =>  $this->string()->notNull(),
            'place_work' => $this->string()->notNull(),
            'post' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
