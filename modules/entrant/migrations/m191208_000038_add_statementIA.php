<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use \yii\db\Migration;

class m191208_000038_add_statementIA extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementIndividualAchievements::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'edu_level' => $this->integer(1)->notNull(),
            'count_pages' => $this->integer()->defaultValue(0)->comment("количество страниц"),
            'counter' => $this->integer()->notNull(),
            'status' => $this->integer(1)->notNull(),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-statement_individual-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-statement_individual-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
