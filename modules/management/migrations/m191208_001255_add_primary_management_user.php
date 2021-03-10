<?php
namespace modules\management\migrations;

use modules\management\models\DictTask;
use modules\management\models\ManagementUser;
use modules\management\models\PostRateDepartment;
use \yii\db\Migration;

class m191208_001255_add_primary_management_user extends Migration
{
    private function table() {
        return ManagementUser::tableName();
    }

    public function up()
    {
        $this->addPrimaryKey('primary-key-mu',$this->table(),['user_id', 'post_rate_id']);
    }
}
