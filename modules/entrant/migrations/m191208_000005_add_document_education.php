<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000005_add_document_education extends Migration
{
    private function table() {
        return \modules\entrant\models\DocumentEducation::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'school_id' => $this->integer()->notNull()->comment("Учебное заведение"),
            'type' => $this->integer(3)->null()->comment('Тип документа'),
            'series' => $this->string()->null()->comment('Серия'),
            'number' => $this->string()->null()->comment("Номер"),
            'date' => $this->date()->null()->comment("От"),
            'year' => $this->string()->null()->comment("Год окончания"),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-document-education-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-document-education-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-document-education-school_id}}', $this->table(), 'school_id');
        $this->addForeignKey('{{%fk-idx-document-education-school_id}}', $this->table(), 'school_id', \dictionary\models\DictSchools::tableName(), 'id',  'RESTRICT', 'RESTRICT');
        $this->createIndex('{{%idx-document-education-type}}', $this->table(), 'type');
        $this->addForeignKey('{{%fk-idx-document-education-type}}', $this->table(), 'type', \modules\entrant\models\dictionary\DictIncomingDocumentType::tableName(),
            'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
