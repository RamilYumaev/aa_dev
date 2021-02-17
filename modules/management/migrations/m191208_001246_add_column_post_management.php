<?php
namespace modules\management\migrations;

use modules\management\models\DictDepartment;
use modules\management\models\PostManagement;
use \yii\db\Migration;

class m191208_001246_add_column_post_management extends Migration
{
    private function table() {
        return PostManagement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "name_genitive", $this->string()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn($this->table(), "name_genitive");
    }
}
