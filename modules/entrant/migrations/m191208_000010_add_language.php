<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000010_add_language extends Migration
{
    private function table() {
        return \modules\entrant\models\Language::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull()->comment('Иностранный язык'),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-language-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-language-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-language-language_id}}', $this->table(), 'language_id');
        $this->addForeignKey('{{%fk-idx-language-language_id}}', $this->table(), 'language_id', \modules\dictionary\models\DictForeignLanguage::tableName(),
            'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
