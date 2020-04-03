<?php

namespace modules\entrant\migrations;

use modules\dictionary\models\DictIndividualAchievement;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\UserIndividualAchievements;
use \yii\db\Migration;

class m191208_000017_add_user_id extends Migration
{
    private function table()
    {
        return UserIndividualAchievements::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->comment("ID пользователя"),
            'individual_id' => $this->smallInteger(5)->notNull()->comment("ID индивидуального достижения"),
            'document_id' => $this->integer(11)->notNull()->comment("ID документа"),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_id}}', $this->table(), ['user_id']);
        $this->createIndex('{{%idx-individual_id}}', $this->table(), ['individual_id']);
        $this->addForeignKey("fk-user_id", $this->table(),
            "user_id", "{{user}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk-individual-key", $this->table(), "individual_id",
            DictIndividualAchievement::tableName(), "id", "CASCADE", "CASCADE");

        $this->addForeignKey("fk-documents-key", $this->table(), "document_id",
            OtherDocument::tableName(), "id", "CASCADE", "CASCADE");

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
