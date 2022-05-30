<?php

namespace modules\superservice\migrations;

use yii\db\Migration;


class m200334_000001_add_document_type_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    private function table()
    {
        return 'ss_model_documents';
    }

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'id_type_document' => $this->integer()->notNull(),
            'id_type_document_version' => $this->integer()->notNull(),
            'record_id' => $this->integer()->notNull(),
            'model' => $this->string()->notNull(),
            'additional' => $this->boolean(),
            'data_json' => $this->json(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
