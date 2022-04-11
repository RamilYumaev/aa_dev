<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000067_update_table_register_competition_list extends Migration
{
    private function table() {
        return 'register_competition_list';
    }

    public function up()
    {
        $this->dropForeignKey('{{%fk-idx-register_competition_list-se_id}}', $this->table());
        $this->addForeignKey('{{%fk-idx-register_competition_list-se_id}}', $this->table(), 'se_id', SettingEntrant::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
