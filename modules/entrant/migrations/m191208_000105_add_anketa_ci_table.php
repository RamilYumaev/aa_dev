<?php
namespace modules\entrant\migrations;
use common\auth\models\User;

class m191208_000105_add_anketa_ci_table extends \yii\db\Migration {
    private function table(){
        return "anketa_ci";
    }
    public function up(){
        $tableOption = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=innoDB";
    $this->createTable($this->table(), [
        'id'=>$this->primaryKey(),
        'talon'=>$this->string(56)->notNull(),
        'lastName'=>$this->string(255)->notNull(),
        'firstName'=>$this->string(255)->notNull(),
        'patronymic'=>$this->string(255)->null(),
        'operator_id'=>$this->integer()->notNull(),
        'phone'=>$this->string(25)->notNull(),
        'email'=>$this->string(255)->notNull(),
    ], $tableOption);

    $this->createIndex('{{%idx-anketa_ci_talon}}', $this->table(), 'talon',true);
   $this->createIndex('{{%idx-anketa_ci_phone}}', $this->table(),'phone',true);
   $this->createIndex('{{%idx-anketa_ci_email}}',$this->table(),'email',true);
    $this->addForeignKey("{{%fk-anketa_ci-operator_id}}", $this->table(), 'operator_id', User::tableName(),'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }

}