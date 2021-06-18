<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000014_transfer extends Migration
{
    private function table() {
        return 'transfer_mpgu';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'year', $this->integer(4)->null());
    }
}
