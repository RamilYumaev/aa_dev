<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictClass;
use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000045_add_table_setting_entrant extends Migration
{
    private function table() {
        return 'setting_entrant';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->null(),
            'datetime_start'=> $this->dateTime()->notNull(),
            'datetime_end'=> $this->dateTime()->notNull(),
            'faculty_id' => $this->integer()->null(),
            'form_edu' => $this->smallInteger()->notNull(),
            'finance_edu' => $this->smallInteger()->notNull(),
            'special_right' => $this->smallInteger()->notNull(),
            'note' => $this->text()->notNull(),
            'is_vi' => $this->boolean()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
