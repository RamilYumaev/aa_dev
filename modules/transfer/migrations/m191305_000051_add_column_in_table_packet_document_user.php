<?php
namespace modules\transfer\migrations;

use modules\transfer\models\PassExam;
use \yii\db\Migration;

class m191305_000051_add_column_in_table_packet_document_user extends Migration
{
    private function table() {
        return 'packet_document_user';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'cause_id', $this->integer(1)->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'cause_id');
    }
}
