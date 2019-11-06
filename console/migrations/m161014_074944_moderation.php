<?php

use yii\db\Migration;

class m161014_074944_moderation extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%moderation}}',
            [
                'id' => $this->primaryKey(),
                'model' => $this->string(255)->null()->defaultValue(null),
                'record_id' => $this->integer(11)->null()->defaultValue(null),
                'action' => $this->smallInteger(1)->null()->defaultValue(null),
                'before' => $this->text()->null()->defaultValue(null),
                'after' => $this->text()->null()->defaultValue(null),
                'message' => $this->string()->null()->defaultValue(null),
                'created_by' => $this->integer(11)->null()->defaultValue(null),
                'created_at' => $this->dateTime()->notNull()->defaultValue(null),
                'updated_at' => $this->dateTime()->notNull()->defaultValue(null),
            ],
            $options
        );

        $this->createIndex('model_record_id', '{{%moderation}}', ['model', 'record_id'], true);
        $this->createIndex('created_by', '{{%moderation}}', ['created_by']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%moderation}}');
    }
}
