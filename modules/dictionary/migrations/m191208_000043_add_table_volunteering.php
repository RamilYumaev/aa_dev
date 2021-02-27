<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictClass;
use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000043_add_table_volunteering extends Migration
{
    private function table() {
        return 'volunteering';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'job_entrant_id'=> $this->integer()->notNull(),
            'faculty_id' => $this->integer()->null(),
            'form_edu' => $this->smallInteger()->notNull(),
            'course_edu' => $this->integer(3)->notNull(),
            'number_edu' => $this->string()->notNull(),
            'finance_edu' =>$this->smallInteger()->notNull(),
            'experience' => $this->boolean(),
            'clothes_type' => $this->smallInteger()->notNull(),
            'clothes_size' => $this->string(5)->notNull(),
            'desire_work'  => $this->json(),
            'link_vk' => $this->string()->defaultValue('')->notNull(),
            'note' => $this->string()->defaultValue('')->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-volunteering-faculty}}', $this->table(), 'faculty_id');
        $this->addForeignKey('{{%fk-volunteering-faculty}}', $this->table(), 'faculty_id', Faculty::tableName(), 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-volunteering-course_edu}}', $this->table(), 'course_edu');
        $this->addForeignKey('{{%fk-volunteering-course_edu}}', $this->table(), 'course_edu', DictClass::tableName(), 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-volunteering-job_entrant_id}}', $this->table(), 'job_entrant_id');
        $this->addForeignKey('{{%fk-volunteering-job_entrant_id}}', $this->table(), 'job_entrant_id', JobEntrant::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
