<?php
namespace modules\dictionary\migrations;
use \yii\db\Migration;

class m191208_000054_add_table_competition_lists  extends Migration
{
    private function table() {
        return 'competition_list';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'ais_cg_id'=> $this->integer()->notNull(),
            'datetime'=> $this->dateTime()->notNull(),
            'status' => $this->integer()->notNull(),
            'json_file' => $this->string()->defaultValue(''),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
