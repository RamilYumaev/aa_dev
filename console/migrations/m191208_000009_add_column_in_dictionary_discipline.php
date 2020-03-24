<?php

use \yii\db\Migration;

class m191208_000009_add_column_in_dictionary_discipline extends Migration
{
    private function table() {
        return \dictionary\models\DictDiscipline::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'cse_subject_id', $this->integer()->null()->comment('Предмет ЕГЭ'));

        $this->createIndex('{{%idx-dict_discipline-cse_subject_id}}', $this->table(), 'cse_subject_id');
        $this->addForeignKey('{{%fk-idx-dict_discipline-cse_subject_id}}', $this->table(), 'cse_subject_id', \modules\dictionary\models\DictCseSubject::tableName(), 'id',  'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'count');
    }
}
