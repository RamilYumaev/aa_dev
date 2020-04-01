<?php

namespace modules\dictionary\migrations;

use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\models\DictIndividualAchievementDocument;
use \yii\db\Migration;

class m191208_000024_add_dict_individual_achievement_document extends Migration
{

    public function table(){
        return DictIndividualAchievementDocument::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'individual_achievement_id' => $this->smallInteger(5)->notNull(),
            'document_type_id' => $this->tinyInteger(3)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('dict_individual_achievement_document-primary', $this->table(), ['individual_achievement_id', 'document_type_id']);


        $this->createIndex('{{%idx-diad-individual_achievement_id}}', $this->table(), 'individual_achievement_id');
        $this->addForeignKey('{{%fk-idx-diad-individual_achievement_id}}', $this->table(), 'individual_achievement_id', DictIndividualAchievement::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-diad-document_type_id}}', $this->table(), 'document_type_id');
        $this->addForeignKey('{{%fk-idx-diad-document_type_id}}', $this->table(), 'document_type_id', \modules\dictionary\models\DictIncomingDocumentType::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
