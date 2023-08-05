<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000153_add_order_transfer_ones extends Migration
{
    private function table() {
        return 'order_transfer_ones';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'department' => $this->string(),
            'type_competitive' => $this->json(),
            'education_level' => $this->json(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
