<?php
namespace modules\management\migrations;

use modules\management\models\DictDepartment;
use \yii\db\Migration;

class m191208_001242_add_column_dict_department extends Migration
{
    private function table() {
        return DictDepartment::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "name_short", $this->string()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn($this->table(), "name_short");
    }
}
