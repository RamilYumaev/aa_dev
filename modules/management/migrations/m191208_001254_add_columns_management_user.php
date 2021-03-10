<?php
namespace modules\management\migrations;

use modules\management\models\DictTask;
use modules\management\models\ManagementUser;
use modules\management\models\PostRateDepartment;
use \yii\db\Migration;

class m191208_001254_add_columns_management_user extends Migration
{
    private function table() {
        return ManagementUser::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_assistant',  $this->boolean()->defaultValue(0));
    }
}
