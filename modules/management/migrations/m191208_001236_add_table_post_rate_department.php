<?php
namespace modules\management\migrations;
use modules\management\models\DictDepartment;
use modules\management\models\PostManagement;
use \yii\db\Migration;

class m191208_001236_add_table_post_rate_department extends Migration
{
    private function table() {
        return 'post_rate_department';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id'=> $this->primaryKey(),
            'dict_department_id' => $this->integer()->null(),
            'post_management_id' => $this->integer()->notNull(),
            'rate'=> $this->integer(2)->notNull(),
            
        ], $tableOptions);

        $this->createIndex('{{%idx-post_rate_department-post_management_id}}', $this->table(), 'post_management_id');
        $this->addForeignKey('{{%fk-idx-post_rate_department-post_management_id}}', $this->table(),
            'post_management_id', PostManagement::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-post_rate_department-dict_department_id}}', $this->table(), 'dict_department_id');
        $this->addForeignKey('{{%fk-post_rate_department-dict_department_id}}', $this->table(), 'dict_department_id', DictDepartment::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }



    public function down()
    {
        $this->dropTable($this->table());
    }
}
