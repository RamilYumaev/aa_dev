<?php
namespace modules\entrant\migrations;

use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Event;
use \yii\db\Migration;

class m191208_000134_add_event_cg extends Migration
{
    private function table() {
        return 'event_cg';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'cg_id' => $this->integer()->notNull(),
            'event_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('event_cg-primary', $this->table(), ['cg_id', 'event_id']);
        $this->addForeignKey("fk-cg-key", $this->table(), "cg_id",
            DictCompetitiveGroup::tableName(), "id", "CASCADE",  'RESTRICT');
        $this->addForeignKey("fk-event-key", $this->table(), "event_id",
            Event::tableName(), "id", "CASCADE",  'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
