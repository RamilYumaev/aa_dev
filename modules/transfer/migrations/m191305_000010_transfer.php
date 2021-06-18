<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000010_transfer extends Migration
{
    private function table() {
        return 'transfer_mpgu';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'data_mpgsu', $this->json());
    }
}
