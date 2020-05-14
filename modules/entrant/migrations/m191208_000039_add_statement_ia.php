<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictIndividualAchievement;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use \yii\db\Migration;

class m191208_000039_add_statement_ia extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementIa::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'statement_individual_id' => $this->integer()->notNull(),
            'individual_id' => $this->smallInteger(5)->notNull(),
            'status_id' => $this->integer(1)->null(),
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_ia-statement_individual_id}}', $this->table(), 'statement_individual_id');
        $this->addForeignKey('{{%fk-idx-statement_ia-statement_individual_id}}', $this->table(), 'statement_individual_id', StatementIndividualAchievements::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-statement_ia-individual_id}}', $this->table(), 'individual_id');
        $this->addForeignKey('{{%fk-idx-statement_ia-individual_id}}', $this->table(), 'individual_id', DictIndividualAchievement::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
