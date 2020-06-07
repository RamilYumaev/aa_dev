<?php

namespace modules\entrant\migrations;
use common\auth\models\User;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191208_000057_add_legal_entity extends Migration
{
    private function table() {
        return 'legal_entity';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'postcode' => $this->string()->notNull(),
            'address' => $this->text()->notNull(),
            'phone' => $this->string()->notNull(),
            'bank' => $this->string()->notNull(),
            'ogrn'=> $this->string()->notNull(),
            'inn' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-legal_entity-user_id}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-legal_entity-user_id}}', $this->table(), 'user_id', User::tableName(),
            'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
