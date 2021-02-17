<?php
namespace modules\management\migrations;

use modules\management\models\Task;
use \yii\db\Migration;

class m191208_001227_add_columns_task extends Migration
{
    private function table() {
        return Task::tableName();
    }

    public function up()
    {
        $this->truncateTable($this->table());
        $this->addColumn($this->table(), 'date_begin',  $this->date()->notNull()->after('position'));
        $this->addColumn($this->table(), 'responsible_user_id',  $this->integer(11)->notNull()->after('director_user_id'));
        $this->addColumn($this->table(), 'status',  $this->integer(2)->notNull()->defaultValue(1));

        $this->createIndex('{{%idx-task-responsible_user}}', $this->table(), 'responsible_user_id');
        $this->addForeignKey('{{%fk-idx-responsible_user}}', $this->table(), 'responsible_user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropColumn($this->table(), "date_begin");
        $this->dropColumn($this->table(), "responsible_user_id");
        $this->dropColumn($this->table(), "status");
    }
}
