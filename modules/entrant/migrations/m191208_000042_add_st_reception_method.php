<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use \yii\db\Migration;

class m191208_000027_add_statement extends Migration
{
    private function table() {
        return \modules\entrant\models\Statement::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'faculty_id' => $this->integer()->notNull(),
            'speciality_id' => $this->integer()->notNull(),
            'edu_level' => $this->integer(1)->notNull(),
            'special_right' => $this->integer(1)->notNull(),
            'counter' => $this->integer()->notNull(),
            'submitted' => $this->integer(1)->notNull(),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-statement-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-statement-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-statement-faculty_id}}', $this->table(), 'faculty_id');
        $this->addForeignKey('{{%fk-statement-faculty_id}}', $this->table(), 'faculty_id', Faculty::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-statement-speciality_id}}', $this->table(), 'speciality_id');
        $this->addForeignKey('{{%fk-statement-speciality_id}}', $this->table(), 'speciality_id', DictSpeciality::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
