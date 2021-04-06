<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000104_add_table_insurance_certificate extends Migration
{
    private function table() {
        return  'insurance_certificate_user';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'number' => $this->string(14)->notNull()
        ], $tableOptions);

        $this->createIndex('{{%idx-insurance_certificate_user-user_id}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-insurance_certificate_user-user_id}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
