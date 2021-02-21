<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001249_add_column_date_work extends Migration
{
    private function table() {
        return 'date_work';
    }

    public function up()
    {
       $this->addColumn( $this->table(), 'id', $this->primaryKey());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
