<?php
namespace modules\management\migrations;

use modules\management\models\DictTask;
use modules\management\models\PostRateDepartment;
use \yii\db\Migration;

class m191208_001253_add_columns_post_rate_department extends Migration
{
    private function table() {
        return PostRateDepartment::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'template_file',  $this->string()->defaultValue(''));
    }
}
